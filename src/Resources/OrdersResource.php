<?php

namespace Tripletex\Resources;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Tripletex\Contracts\ResourceInterface;
use Tripletex\Enum\Method;
use Tripletex\Exceptions\FailedToSendRequestException;
use Tripletex\Model\Customer;
use Tripletex\Model\ErrorResponse;
use Tripletex\Model\Order;
use Tripletex\Exceptions\ApiException;
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
    use CanAccessSDK;
    use CanCreateRequest;
    use CanUpdateResource;
    use CanCreateCollection;
    use CanCreateResource;
    use CanFindResource;

    /**
     * @param array{customer: int, orderDate: string, deliveryDate: string} $data
     * @throws FailedToCreateResourceException
     * @throws ApiException
     */
    public function create(array $data): Order|ErrorResponse
    {
        $order = Order::make($data);

        return $this->createResource(
            model: $order,
            path: 'order',
        );
    }

    /**
     * @throws ApiException
     */
    public function update(array $data): Order|ErrorResponse
    {
        /** @var Order $order */
        $order = Order::make($data);

        return $this->updateResource(
            model: $order,
            path: 'order/'.$order->id,
        );
    }

    public function addOrderGroup(array $data): OrderGroup|ErrorResponse
    {
        /** @var OrderGroup $orderGroup */
        $orderGroup = OrderGroup::make($data);

        return $this->createResource(
            model: $orderGroup,
            path: 'order/orderGroup',
        );
    }
    /**
     * @throws ApiException
     */
    public function find(int $id, ?string $fields): Order|ErrorResponse
    {
        $query = $fields ? '?fields='.$fields : '';
        return $this->findResource(
            modelClass: Order::class,
            path: 'order/'.$id.$query,
        );
    }

    /**
     * @throws ApiException
     */
    public function approveSubscriptionInvoice(int $orderId, \DateTimeInterface $invoiceDate): ResponseInterface
    {
        $url = 'order/'.$orderId.'/:approveSubscriptionInvoice';
        $query = ['invoiceDate' => $invoiceDate->format('Y-m-d')];
        $request = $this->request(
            method: Method::PUT,
            url: $url,
            query: $query
        );
        return $this->sendRequest($request);
    }

    /**
     * @throws ApiException
     */
    public function unApproveSubscriptionInvoice(int $orderId): ResponseInterface
    {
        $url = 'order/'.$orderId.'/:unApproveSubscriptionInvoice';
        $request = $this->request(
            method: Method::PUT,
            url: $url
        );
        return $this->sendRequest($request);
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
