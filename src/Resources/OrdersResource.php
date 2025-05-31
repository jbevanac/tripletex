<?php

namespace Tripletex\Resources;

use JustSteveKing\Tools\Http\Enums\Method;
use Ramsey\Collection\Collection;
use Tripletex\Contracts\ModelInterface;
use Tripletex\Contracts\ResourceInterface;
use Tripletex\DTO\Customer;
use Tripletex\DTO\Order;
use Tripletex\Enum\Sort;
use Tripletex\Exceptions\ApiException;
use Tripletex\Exceptions\FailedToCreateResourceException;
use Tripletex\Exceptions\FailedToFetchResourceException;
use Tripletex\Resources\Concerns\CanAccessSDK;
use Tripletex\Resources\Concerns\CanCreateRequest;
use Tripletex\Resources\Concerns\CanCreateResource;

final class OrdersResource implements ResourceInterface
{
    use CanAccessSDK;
    use CanCreateRequest;
    use CanCreateResource;

}
