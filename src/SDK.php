<?php

namespace Tripletex;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use JustSteveKing\Tools\Http\Enums\Method;
use Tripletex\Resources\CustomerResource;
use Psr\SimpleCache\CacheInterface;

final readonly class SDK
{
    private const string AUTH_ROUTE = '/token/session/:create';
    private const string LOGOUT_ROUTE = '/token/session/';
    private ?string $sessionToken;
    public function __construct(
        private string $url,
        private string $consumerToken,
        private string $employeeToken,
        private ?CacheInterface $cache = null,
        private string $cacheKey = 'tripletex_session_token',
        private int $cacheLifeTime = 86400,
    ) {
        $this->loadOrCreateSessionToken();
        var_dump($this->sessionToken);
    }

    private function loadOrCreateSessionToken(): void
    {
        if ($this->cache) {
            $token = $this->cache->get($this->cacheKey);
            if ($token) {
                $this->sessionToken = $token;
                var_dump('found');
                return;
            }
        }

        $token = $this->authenticate();
        if ($this->cache) {
            $this->cache->set($this->cacheKey, $token, $this->cacheLifeTime);
        }
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
            ->withHeader('Authorization', 'Basic '.$this->getAuth());

        $client = Psr18ClientDiscovery::find();
        $response = $client->sendRequest($request);

        if ($response->getStatusCode() !== 204) {
            // throw new \RuntimeException('Did not log out');
        }
    }

    public function getAuth(): string
    {
        return base64_encode("0:$this->sessionToken");
    }
    public function customers(): CustomerResource
    {
        return new CustomerResource(
            sdk: $this,
        );
    }

    public function getUrl(): string
    {
        return $this->url;
    }

}
