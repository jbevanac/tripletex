<?php

namespace Tripletex\Resources;

use Psr\Http\Message\ResponseInterface;
use Tripletex\Contracts\ResourceInterface;
use Tripletex\Enum\Method;
use Tripletex\Model\ErrorResponse;
use Tripletex\Model\Order;
use Tripletex\Exceptions\TripletexException;
use Tripletex\Exceptions\FailedToCreateResourceException;
use Tripletex\Model\OrderGroup;
use Tripletex\Resources\Concerns\CanAccessSDK;
use Tripletex\Resources\Concerns\CanCreateCollection;
use Tripletex\Resources\Concerns\CanCreateRequest;
use Tripletex\Resources\Concerns\CanCreateResource;
use Tripletex\Resources\Concerns\CanFindResource;
use Tripletex\Resources\Concerns\CanUpdateResource;

final class OrdersResource implements ResourceInterface
{
    private const string PATH = 'order';

    use CanAccessSDK;
    use CanCreateRequest;
    use CanUpdateResource;
    use CanCreateCollection;
    use CanCreateResource;
    use CanFindResource;

    /**
     * @param array{customer: int, orderDate: string, deliveryDate: string} $data
     * @throws FailedToCreateResourceException
     * @throws TripletexException
     */
    public function create(array $data): Order|ErrorResponse
    {
        $order = Order::make($data);

        return $this->createResource(
            model: $order,
            path: self::PATH,
        );
    }

    /**
     * @throws TripletexException
     */
    public function update(array $data): Order|ErrorResponse
    {
        $order = Order::make($data);

        return $this->updateResource(
            model: $order,
            path: [self::PATH, $order->id],
        );
    }

    /**
     * @throws TripletexException
     */
    public function addOrderGroup(array $data): OrderGroup|ErrorResponse
    {
        $orderGroup = OrderGroup::make($data);

        return $this->createResource(
            model: $orderGroup,
            path: [self::PATH, 'orderGroup'],
        );
    }
    /**
     * @throws TripletexException
     */
    public function find(int $id, array $filters = []): Order|ErrorResponse
    {
        return $this->findResource(
            modelClass: Order::class,
            path: [self::PATH, $id],
            filters: $filters,
        );
    }

    /**
     * @throws TripletexException
     */
    public function approveSubscriptionInvoice(int $orderId, \DateTimeInterface $invoiceDate): ResponseInterface
    {
        $filters = ['invoiceDate' => $invoiceDate->format('Y-m-d')];
        $request = $this->request(
            method: Method::PUT,
            url: [self::PATH, $orderId, ':approveSubscriptionInvoice'],
            filters: $filters,
        );
        return $this->sendRequest($request);
    }

    /**
     * @throws TripletexException
     */
    public function unApproveSubscriptionInvoice(int $orderId): ResponseInterface
    {
        $request = $this->request(
            method: Method::PUT,
            url: [self::PATH, $orderId, ':unApproveSubscriptionInvoice'],
        );
        return $this->sendRequest($request);
    }
}
