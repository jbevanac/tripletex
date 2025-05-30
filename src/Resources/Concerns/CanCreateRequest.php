<?php

namespace Tripletex\Resources\Concerns;

use Http\Discovery\Psr17FactoryDiscovery;
use JustSteveKing\Tools\Http\Enums\Method;
use Psr\Http\Message\RequestInterface;
use Tripletex\Contracts\ResourceInterface;

/**
 * @mixin ResourceInterface
 */
trait CanCreateRequest
{
    public function request(Method $method, string $path, array $query = [], ?string $body = null, array $headers = []): RequestInterface {
        $uri = rtrim($this->getSdk()->getUrl(), '/') . '/' . ltrim($path, '/');

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

        foreach ($headers as $name => $value) {
            $request = $request->withHeader($name, $value);
        }

        return $request;
    }
}