<?php

namespace Tripletex\Contracts;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Ramsey\Collection\Collection;
use Tripletex\Enum\Method;
use Tripletex\TripletexSDK;

interface ResourceInterface
{
    public function request(Method $method, array|string $url, array $filters = [], ?string $body = null, array $headers = []): RequestInterface;

    public function getSdk(): TripletexSDK;

    public function createCollection(string $modelClass, array $data): Collection;

    public function sendRequest(RequestInterface $request): ResponseInterface;
}
