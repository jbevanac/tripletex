<?php

namespace Tripletex\Resources\Concerns;

use Http\Discovery\Psr17FactoryDiscovery;
use JustSteveKing\Tools\Http\Enums\Method;
use Psr\Http\Message\RequestInterface;
use Tripletex\Contracts\ResourceInterface;
use Tripletex\Resources\Filters\Filter;

/**
 * @mixin ResourceInterface
 */
trait CanCreateRequest
{
    public function request(Method $method, string $url, array $query = [], ?string $body = null, array $headers = []): RequestInterface {
        $uri = rtrim($this->getSdk()->getUrl(), '/') . '/' . ltrim($url, '/');

        if (!empty($query)) {
            $uri .= '?' . http_build_query($query);
        }

        $requestFactory = Psr17FactoryDiscovery::findRequestFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        $request = $requestFactory->createRequest($method->value, $uri);

        if ($body !== null) {
            $stream = $streamFactory->createStream($body);
            $request = $request->withBody($stream);
        }

        if (!isset($headers['Authorization'])) {
            $headers['Authorization'] = 'Basic ' . $this->getSdk()->getToken();
        }
        if (!isset($headers['Content-Type'])){
            $headers['Content-Type'] = 'application/json';
        }

        foreach ($headers as $name => $value) {
            $request = $request->withHeader($name, $value);
        }

        return $request;
    }

    /**
     * @param RequestInterface $request
     * @param array<int,Filter> $filters
     * @return RequestInterface
     */
    public function applyFilters(RequestInterface $request, array $filters): RequestInterface
    {
        $uri = $request->getUri();
        foreach ($filters as $filter) {
            $uri = $uri->withQuery(
                query: $filter->toQueryParameter(),
            );
        }

        return $request->withUri(
            uri: $uri,
            preserveHost: true,
        );
    }

    public function attachPayLoad(RequestInterface $request, string $payload): RequestInterface
    {
        return $request->withBody(
            body: Psr17FactoryDiscovery::findStreamFactory()->createStream(
                content: $payload,
            )
        );
    }
}