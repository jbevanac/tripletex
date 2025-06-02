<?php

namespace Tripletex\Resources;

use Ramsey\Collection\Collection;
use Tripletex\Contracts\ResourceInterface;
use Tripletex\DTO\ErrorResponse;
use Tripletex\DTO\Order;
use Tripletex\Exceptions\ApiException;
use Tripletex\Exceptions\FailedToCreateResourceException;
use Tripletex\Exceptions\FailedToSendRequestException;
use Tripletex\Resources\Concerns\CanAccessSDK;
use Tripletex\Resources\Concerns\CanCreateRequest;
use Tripletex\Resources\Concerns\CanCreateResource;
use Tripletex\Resources\Concerns\CanFindResource;
use Tripletex\Resources\Concerns\CanListResource;

final class OrdersResource implements ResourceInterface
{
    use CanAccessSDK;
    use CanCreateRequest;
    use CanCreateResource;
    use CanFindResource;
    use CanListResource;

    /**
     * @throws FailedToCreateResourceException
     * @throws ApiException
     */
    public function create(array $order): Order|ErrorResponse
    {
        $order = Order::make($order);

        return $this->createResource(
            dto: $order
        );
    }

    /**
     * @throws FailedToCreateResourceException
     * @throws ApiException
     */
    public function find(int $id): Order|ErrorResponse
    {
        return $this->findResource(
            modelClass: Order::class,
            id: $id,
        );
    }


    /**
     * @throws FailedToSendRequestException
     * @throws ApiException
     */
    public function list(array $filters = [], ?int $page = null): Collection|ErrorResponse
    {
        return $this->listResource(
            modelClass: Order::class,
            filters: $filters,
            page: $page
        );
    }
}
