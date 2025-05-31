<?php

namespace Tripletex\Resources;

use Tripletex\Contracts\ResourceInterface;
use Tripletex\Resources\Concerns\CanAccessSDK;
use Tripletex\Resources\Concerns\CanCreateRequest;
use Tripletex\Resources\Concerns\CanCreateResource;

class InvoicesResource implements ResourceInterface
{
    use CanAccessSDK;
    use CanCreateRequest;
    use CanCreateResource;

}
