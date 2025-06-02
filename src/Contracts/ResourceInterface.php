<?php

namespace Tripletex\Contracts;

use JustSteveKing\Tools\Http\Enums\Method;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Ramsey\Collection\Collection;
use Tripletex\TripletexSDK;

interface ResourceInterface
{
    public function request(Method $method, string $url): RequestInterface;

    public function getSdk(): TripletexSDK;

    public function attachPayLoad(RequestInterface $request, string $payload): RequestInterface;

    public function createCollection(string $modelClass, array $data): Collection;

    public function sendRequest(RequestInterface $request): ResponseInterface;
}
