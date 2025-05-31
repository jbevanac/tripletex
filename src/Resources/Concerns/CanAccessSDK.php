<?php

namespace Tripletex\Resources\Concerns;

use Tripletex\Contracts\ResourceInterface;
use Tripletex\TripletexSDK;

/**
 * @mixin ResourceInterface
 */
trait CanAccessSDK
{
    public function __construct(
        private readonly TripletexSDK $sdk,
    ) {
    }

    public function getSdk(): TripletexSDK
    {
        return $this->sdk;
    }
}