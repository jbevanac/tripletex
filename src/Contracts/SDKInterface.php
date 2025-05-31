<?php

namespace Tripletex\Contracts;

use Psr\Http\Client\ClientInterface;
use Tripletex\TripletexSDK;

interface SDKInterface
{
    public function withPlugins(array $plugins): TripletexSDK;

    public function defaultPlugins(): array;

    public function client(): ClientInterface;

    public function setClient(ClientInterface $client): TripletexSDK;

    public function getUrl(): string;

    public function getToken(): string;
}