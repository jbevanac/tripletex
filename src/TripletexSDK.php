<?php

namespace Tripletex;

use Http\Client\Common\Plugin\AuthenticationPlugin;
use Http\Client\Common\Plugin\ErrorPlugin;
use Http\Client\Common\Plugin\RetryPlugin;
use Http\Client\Common\PluginClient;
use Http\Discovery\Composer\Plugin;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Http\Message\Authentication\Bearer;
use Psr\Http\Client\ClientInterface;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Tripletex\Contracts\SDKInterface;
use Tripletex\Enum\Method;
use Tripletex\Resources\CustomerResource;
use Psr\SimpleCache\CacheInterface;
use Tripletex\Resources\InvoicesResource;
use Tripletex\Resources\OrdersResource;

final class TripletexSDK implements SDKInterface
{
    private const string AUTH_ROUTE = '/token/session/:create';
    private const string LOGOUT_ROUTE = '/token/session/';
    private ?string $sessionToken;

    public function __construct(
        private readonly string $url,
        private readonly string $consumerToken,
        private readonly string $employeeToken,
        private ?ClientInterface $client = null,
        private readonly ?CacheInterface $cache = null,
        private readonly string $cacheKey = 'tripletex_session_token',
        private readonly int $cacheLifeTime = 129600,
        private array $plugins = [],
    ) {
        $this->loadOrCreateSessionToken();
    }

    private function loadOrCreateSessionToken(): void
    {
        if ($this->cache) {
            $token = $this->cache->get($this->cacheKey);
            if ($token) {
                $this->sessionToken = $token;
                return;
            }
        }

        $token = $this->authenticate();
        $this->cache?->set($this->cacheKey, $token, $this->cacheLifeTime);
        $this->sessionToken = $token;
    }

    private function authenticate(): string
    {
        $expirationDate = (new \DateTimeImmutable())
            ->add(new \DateInterval('PT' . $this->cacheLifeTime . 'S'))
            ->format('Y-m-d');

        $query = http_build_query([
            'consumerToken' => $this->consumerToken,
            'employeeToken' => $this->employeeToken,
            'expirationDate' => $expirationDate,
        ]);

        $uri = rtrim($this->url, '/').self::AUTH_ROUTE.'?'.$query;

        $requestFactory = Psr17FactoryDiscovery::findRequestFactory();
        $request = $requestFactory->createRequest(Method::PUT->value, $uri)
            ->withHeader('Accept', 'application/json');

        $client = Psr18ClientDiscovery::find();
        $response = $client->sendRequest($request);

        $body = (string) $response->getBody();
        $data = json_decode($body, true);

        if (!isset($data['value']['token'])) {
            throw new \RuntimeException("Unable to authenticate with Tripletex API: " . $body);
        }

        return $data['value']['token'];
    }

    public function logout(): void
    {
        // If using a cache, assume token might be reused and skip logout
        if ($this->cache || !$this->sessionToken) {
            return;
        }

        $uri = rtrim($this->url, '/').self::LOGOUT_ROUTE.$this->sessionToken;

        $requestFactory = Psr17FactoryDiscovery::findRequestFactory();
        $request = $requestFactory->createRequest(Method::DELETE->value, $uri)
            ->withHeader('Accept', 'application/json')
            ->withHeader('Authorization', 'Basic '.$this->getToken());

        $client = Psr18ClientDiscovery::find();
        $response = $client->sendRequest($request);

        if ($response->getStatusCode() !== 204) {
            // throw new \RuntimeException('Did not log out');
        }
    }

    public function getToken(): string
    {
        return base64_encode("0:$this->sessionToken");
    }

    public function customers(): CustomerResource
    {
        return new CustomerResource(
            sdk: $this,
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
            new RetryPlugin(),
            new ErrorPlugin(),
            new AuthenticationPlugin(
                new Bearer(
                    token: $this->sessionToken,
                )
            )
        ];
    }

    public function client(): ClientInterface
    {
        if ($this->client !== null) {
            return $this->client;
        }

        $this->client = new PluginClient(
            client: Psr18ClientDiscovery::find(),
            plugins: $this->plugins,
        );

        return $this->client;
    }

    public function setClient(ClientInterface $client): TripletexSDK
    {
        $this->client = $client;

        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public static function getSerializer(): Serializer
    {
         return new Serializer(
            [new BackedEnumNormalizer(), new ObjectNormalizer(null, null, null, new ReflectionExtractor())],
            [new JsonEncoder()]
        );

    }

}
