<?php

namespace Tripletex\Resources\Concerns;

use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Tripletex\Contracts\ResourceInterface;
use Tripletex\Enum\Method;
use Tripletex\Exceptions\FailedToDecodeJsonResponseException;
use Tripletex\Exceptions\FailedToSendRequestException;
use Tripletex\Resources\Filters\Filter;

/**
 * @mixin ResourceInterface
 */
trait CanCreateRequest
{
    public function prepareUrl(string $url): string
    {
        $baseUrl = str_replace('https://', '', rtrim($this->getSdk()->getUrl(), '/'));
        $url = str_replace('https://', '', trim($url, '/'));

        // If the url starts with baseUrl, remove the duplicated base
        if (str_starts_with($url, $baseUrl)) {
            $url = ltrim(substr($url, strlen($baseUrl)), '/');
        }

        return 'https://' . $baseUrl . '/' . $url;
    }

    public function request(Method $method, string $url, array $query = [], ?string $body = null, array $headers = []): RequestInterface {
        $uri = $this->prepareUrl($url);

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
        $uri = $uri->withQuery(
            query: http_build_query($filters),
        );


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

    /**
     * @throws FailedToSendRequestException
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        try {
            return $this->getSdk()->client()->sendRequest(
                request: $request,
            );
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
