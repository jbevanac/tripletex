<?php

namespace Tripletex\Resources;

use Tripletex\Contracts\ResourceInterface;
use Tripletex\Model\ErrorResponse;
use Tripletex\Model\Order;
use Tripletex\Exceptions\ApiException;
use Tripletex\Exceptions\FailedToCreateResourceException;
use Tripletex\Resources\Concerns\CanAccessSDK;
use Tripletex\Resources\Concerns\CanCreateCollection;
use Tripletex\Resources\Concerns\CanCreateRequest;
use Tripletex\Resources\Concerns\CanCreateResource;
use Tripletex\Resources\Concerns\CanFindResource;

final class OrdersResource implements ResourceInterface
{
    use CanAccessSDK;
    use CanCreateRequest;
    use CanCreateCollection;
    use CanCreateResource;
    use CanFindResource;

    /**
     * @throws FailedToCreateResourceException
     * @throws ApiException
     */
    public function create(array $order): Order|ErrorResponse
    {
        $order = Order::make($order);

        return $this->createResource(
            model: $order,
            path: 'order',
        );
    }

    /**
     * @throws ApiException
     */
    public function find(int $id): Order|ErrorResponse
    {
        return $this->findResource(
            modelClass: Order::class,
            path: 'order/'.$id,
        );
    }

    /**
     * @throws ApiException
     */
    public function findRaw(int $id): array
    {
        return $this->findResource(
            modelClass: Order::class,
            path: 'order/'.$id,
            raw: true,
        );
    }

}
