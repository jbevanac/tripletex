<?php

namespace Tripletex\Contracts;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Ramsey\Collection\Collection;
use Tripletex\Enum\Method;
use Tripletex\TripletexSDK;

interface ResourceInterface
{
    public function request(Method $method, string $url, array $query = [], ?string $body = null, array $headers = []): RequestInterface;

    public function getSdk(): TripletexSDK;

    public function attachPayLoad(RequestInterface $request, string $payload): RequestInterface;

    public function createCollection(string $modelClass, array $data): Collection;

    public function sendRequest(RequestInterface $request): ResponseInterface;
}
