<?php

namespace Tripletex\Contracts;

use Psr\Http\Client\ClientInterface;
use Tripletex\SDK;

interface SDKInterface
{
    public function withPlugins(array $plugins): SDK;

    public function defaultPlugins(): array;

    public function client(): ClientInterface;

    public function setClient(ClientInterface $client): SDK;

    public function getUrl(): string;

    public function getToken(): string;
}