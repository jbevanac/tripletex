<?php

namespace Tripletex\Resources\Concerns;

use Tripletex\Contracts\ResourceInterface;
use Tripletex\SDK;

/**
 * @mixin ResourceInterface
 */
trait CanAccessSDK
{
    public function __construct(
        private readonly SDK $sdk,
    ) {
    }

    public function getSdk(): SDK
    {
        return $this->sdk;
    }
}