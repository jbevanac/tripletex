<?php

namespace Tripletex\Contracts;

use JustSteveKing\Tools\Http\Enums\Method;
use Psr\Http\Message\RequestInterface;
use Tripletex\SDK;

interface ResourceInterface
{
    public function request(Method $method, string $url): RequestInterface;

    public function getSdk(): SDK;
}