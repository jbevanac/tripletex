<?php

namespace Tripletex\Resources;

use Tripletex\Contracts\ResourceInterface;
use Tripletex\Resources\Concerns\CanAccessSDK;
use Tripletex\Resources\Concerns\CanCreateRequest;

final class CustomerResource implements ResourceInterface
{
    use CanAccessSDK;
    use CanCreateRequest;

}