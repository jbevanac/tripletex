<?php

namespace Tripletex;

use Http\Client\Common\PluginClient;
use Http\Client\Common\Plugin;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\SimpleCache\InvalidArgumentException;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Tripletex\Contracts\Resources;
use Tripletex\Contracts\SDKInterface;
use Tripletex\Enum\Method;
use Tripletex\Exceptions\Configuration\AuthenticationException;
use Tripletex\Exceptions\Configuration\CacheException;
use Tripletex\Exceptions\Configuration\ConfigurationException;
use Tripletex\Exceptions\Configuration\InvalidExpirationDateException;
use Tripletex\Model\SessionToken;
use Tripletex\Plugins\UserAgentPlugin;
use Tripletex\Resources\ContactResource;
use Tripletex\Resources\CountriesResource;
use Tripletex\Resources\CustomersResource;
use Psr\SimpleCache\CacheInterface;
use Tripletex\Resources\InvoicesResource;
use Tripletex\Resources\OrdersResource;
use Tripletex\Resources\EmployeeResource;

final class TripletexSDK implements SDKInterface, Resources
{
    private const string AUTH_ROUTE = '/token/session/:create';
    private const string LOGOUT_ROUTE = '/token/session/';
    private ?string $sessionToken = null;
    private ?int $sessionTokenExpiresAt = null;
    private ?ClientInterface $client = null;

    public function __construct(
        private readonly string $baseUrl,
        private readonly string $consumerToken,
        private readonly string $employeeToken,
        private readonly ?ClientInterface $customClient = null,
        private readonly ?CacheInterface $cache = null,
        private readonly string $cacheKey = 'tripletex_session_token',
        private readonly int $cacheLifeTime = 129600,
        private array $plugins = [],
    ) {
        $this->withPlugins($this->plugins);
    }

    /**
     * @throws ConfigurationException
     */
    public function loadOrCreateSessionToken(): string
    {
        // Check in-memory token first
        if ($this->sessionToken && $this->sessionTokenExpiresAt && $this->sessionTokenExpiresAt > time()) {
            return $this->sessionToken;
        }

        // Check cache
        if ($this->cache) {
            try {
                $tokenData = $this->cache->get($this->cacheKey);
            } catch (InvalidArgumentException $e) {
                throw new CacheException('Invalid Cache configuration or cache key', $e);
            }
            if ($tokenData instanceof SessionToken) {
                $expiresAt = $this->expirationDateToUnix($tokenData->expirationDate);
                if ($expiresAt > time()) {
                    $this->sessionToken = $tokenData->token;
                    $this->sessionTokenExpiresAt = $this->expirationDateToUnix($tokenData->expirationDate);
                    return $this->sessionToken;
                }
            }
        }

        // Authenticate
        $tokenResponse = $this->authenticate();
        $this->sessionToken = $tokenResponse->token;
        $this->sessionTokenExpiresAt = $this->expirationDateToUnix($tokenResponse->expirationDate);

        // Cache it
        try {
            $ttl = max(0, $this->sessionTokenExpiresAt - time() - 30);
            $this->cache?->set($this->cacheKey, $tokenResponse, $ttl);
        } catch (InvalidArgumentException $e) {
            throw new CacheException('Invalid Cache configuration or cache key', $e);
        }

        return $this->sessionToken;
    }

    /**
     * @throws ConfigurationException
     */
    private function authenticate(): SessionToken
    {
        $expirationDate = $this->calculateExpirationDate($this->cacheLifeTime);

        $query = http_build_query([
            'consumerToken' => $this->consumerToken,
            'employeeToken' => $this->employeeToken,
            'expirationDate' => $expirationDate,
        ]);

        $uri = rtrim($this->baseUrl, '/').self::AUTH_ROUTE.'?'.$query;

        $requestFactory = Psr17FactoryDiscovery::findRequestFactory();
        $request = $requestFactory->createRequest(Method::PUT->value, $uri);

        $client = new PluginClient(
            client: $this->customClient ?? Psr18ClientDiscovery::find(),
            plugins: array_filter(
                $this->plugins,
                fn($plugin) => $plugin instanceof UserAgentPlugin
            )
        );

        try {
            $response = $client->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            throw new ConfigurationException('Failed to authenticate with Tripletex API', $e);
        }

        $body = (string) $response->getBody();
        $data = json_decode($body, true);
        $status = $response->getStatusCode();

        if (200 === $status) {
            return SessionToken::make($data['value']);
        }

        throw new AuthenticationException("Unable to authenticate with Tripletex API: " . $body);
    }

    /**
     * @throws InvalidExpirationDateException
     */
    private function expirationDateToUnix(?string $date): int
    {
        if (!$date) {
            throw new InvalidExpirationDateException('Missing expiration date in token response');
        }

        try {
            // Tripletex expires at CET midnight when the date changes
            $dt = new \DateTimeImmutable(
                $date . ' 00:00:00',
                new \DateTimeZone('Europe/Oslo') // CET/CEST safe
            );
        } catch (\Exception) {
            throw new InvalidExpirationDateException('Invalid expiration date in token response');
        }

        return $dt->getTimestamp();
    }

    /**
     * @throws ConfigurationException
     */
    private function calculateExpirationDate(int $lifetimeSeconds): string
    {
        try {
            $now = new \DateTimeImmutable('now', new \DateTimeZone('Europe/Oslo'));

            // Desired expiration moment
            $desiredExpiration = $now->add(new \DateInterval('PT' . $lifetimeSeconds . 'S'));
        } catch (\Exception) {
            throw new ConfigurationException('Invalid expiration date, try adjusting cacheLifeTime');
        }
        /**
         * Tripletex expires at CET midnight when the date changes.
         * So we must send the *date after* the desired expiration moment.
         */
        return $desiredExpiration
            ->modify('+1 day')
            ->format('Y-m-d');
    }

    /**
     * @throws ConfigurationException
     */
    public function logout(): void
    {
        // If using a cache, assume token might be reused and skip logout
        if ($this->cache || !$this->sessionToken) {
            return;
        }

        $uri = rtrim($this->baseUrl, '/').self::LOGOUT_ROUTE.$this->sessionToken;

        $requestFactory = Psr17FactoryDiscovery::findRequestFactory();
        $request = $requestFactory->createRequest(Method::DELETE->value, $uri);

        $client = new PluginClient(
            client: $this->customClient ?? Psr18ClientDiscovery::find(),
            plugins: array_filter(
                $this->plugins,
                fn($plugin) => $plugin instanceof UserAgentPlugin
            )
        );

        try {
            $response = $client->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            throw new ConfigurationException('Failed to authenticate with Tripletex API.', $e);
        }

        if ($response->getStatusCode() !== 204) {
            throw new ConfigurationException('Did not log out from Tripletex API.');
        }
    }

    /**
     * @param array<int, Plugin> $plugins
     * @return $this
     */
    public function withPlugins(array $plugins): TripletexSDK
    {
        $this->plugins = array_merge(
            $this->defaultPlugins(),
            $plugins,
        );

        return $this;
    }

    public function defaultPlugins(): array
    {
        return [
            new Plugin\HeaderAppendPlugin([
                'Accept' => 'application/json',
            ]),
        ];
    }

    public function client(): ClientInterface
    {
        if (null !== $this->client) {
            return $this->client;
        }

        $httpClient = $this->customClient ?? Psr18ClientDiscovery::find();
        $this->client = new PluginClient(
            client: $httpClient,
            plugins: $this->plugins,
        );

        return $this->client;
    }

    public function getUrl(): string
    {
        return $this->baseUrl;
    }

    public static function getSerializer(): Serializer
    {
         return new Serializer(
            [new BackedEnumNormalizer(), new ObjectNormalizer(null, null, null, new ReflectionExtractor())],
            [new JsonEncoder()]
        );

    }

    /* RESOURCES */

    public function contacts(): ContactResource
    {
        return new ContactResource(
            sdk: $this,
        );
    }

    public function countries(): CountriesResource
    {
        return new CountriesResource(
            sdk: $this,
        );
    }

    public function customers(): CustomersResource
    {
        return new CustomersResource(
            sdk: $this,
        );
    }

    public function employee(): EmployeeResource
    {
        return new EmployeeResource(
            sdk: $this
        );
    }

    public function invoices(): InvoicesResource
    {
        return new InvoicesResource(
            sdk: $this
        );
    }

    public function orders(): OrdersResource
    {
        return new OrdersResource(
            sdk: $this
        );
    }

}
