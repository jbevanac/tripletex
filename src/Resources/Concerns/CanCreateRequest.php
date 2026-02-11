<?php

namespace Tripletex\Resources\Concerns;

use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Tripletex\Contracts\FilterInterface;
use Tripletex\Contracts\ResourceInterface;
use Tripletex\Enum\Method;
use Tripletex\Exceptions\FailedToDecodeJsonResponseException;
use Tripletex\Exceptions\FailedToSendRequestException;
use Tripletex\Plugins\LazyAuthenticationPlugin;

/**
 * @mixin ResourceInterface
 */
trait CanCreateRequest
{
    private function prepareUrl(array|string $url): string
    {
        if (is_array($url)) {
            $url = implode('/', array_map(fn($s) => trim((string)$s, '/'), $url));
        }

        $baseUrl = str_replace('https://', '', rtrim($this->getSdk()->getUrl(), '/'));
        $url = str_replace('https://', '', trim($url, '/'));

        // If the url starts with baseUrl, remove the duplicated base
        if (str_starts_with($url, $baseUrl)) {
            $url = ltrim(substr($url, strlen($baseUrl)), '/');
        }

        return 'https://'.$baseUrl.'/'.$url;
    }

    public function request(Method $method, array|string $url, array $filters = [], ?string $body = null, array $headers = []): RequestInterface
    {
        $uri = $this->prepareUrl($url);

        $requestFactory = Psr17FactoryDiscovery::findRequestFactory();
        $request = $requestFactory->createRequest($method->value, $uri);

        foreach ($headers as $name => $value) {
            $request = $request->withHeader($name, $value);
        }

        if (!empty($filters)) {
            $request = $this->applyFilters($request, $filters);
        }

        if (null !== $body) {
            $request = $this->attachPayLoad($request, $body);
        }

        return $request;
    }

    /**
     * @param RequestInterface $request
     * @param array<int,FilterInterface|scalar|array> $filters
     * @return RequestInterface
     */
    private function applyFilters(RequestInterface $request, array $filters): RequestInterface
    {
        $query = [];

        foreach ($filters as $key => $value) {
            if ($value instanceof FilterInterface) {
                $query = array_merge($query, $value->toQuery());
            } elseif (is_array($value)) {
                $query[$key] = implode(',', $value);
            } else {
                $query[$key] = $value;
            }
        }

        $uri = $request->getUri()->withQuery(
            query: http_build_query($query),
        );

        return $request->withUri(
            uri: $uri,
            preserveHost: true,
        );
    }

    private function attachPayLoad(RequestInterface $request, string $payload): RequestInterface
    {
        return $request->withBody(
            body: Psr17FactoryDiscovery::findStreamFactory()->createStream(
                content: $payload,
            )
        );
    }

    /**
     * @throws FailedToSendRequestException
     */
    public function sendRequest(RequestInterface $request, bool $authenticate = true): ResponseInterface
    {
        $plugins = $authenticate ? [new LazyAuthenticationPlugin($this->getSdk())] : [];
        $sdk = $this->getSdk()->withPlugins($plugins);

        try {
            return $sdk->client()->sendRequest(request: $request);
        } catch (\Throwable $e) {
            throw new FailedToSendRequestException(
                message: 'Failed to send request.',
                previous: $e,
            );
        }
    }

    /**
    * @throws FailedToDecodeJsonResponseException
    */
    public function decodeJsonResponse(ResponseInterface $response): array
    {
        try {
            return json_decode(
                json: $response->getBody()->getContents(),
                associative: true,
                flags: JSON_THROW_ON_ERROR,
            );
        } catch (\JsonException $e) {
            throw new FailedToDecodeJsonResponseException(
                message: 'Invalid JSON response from API',
                code: $e->getCode(),
                previous: $e,
            );
        }
    }
}
