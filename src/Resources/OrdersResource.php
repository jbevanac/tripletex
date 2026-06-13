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
     * @param array{
     *     customer: int,
     *     orderDate: string,
     *     deliveryDate: string,
     *     version?: int,
     *     contact?: int,
     *     attn?: int,
     *     receiverEmail?: string,
     *     overdueNoticeEmail?: string,
     *     number?: string,
     *     reference?: string,
     *     contractReference?: string,
     *     ourContact?: int,
     *     ourContactEmployee?: int,
     *     department?: int,
     *     project?: int,
     *     invoiceComment?: string,
     *     internalComment?: string,
     *     currency?: int,
     *     invoicesDueIn?: int,
     *     invoicesDueInType?: string,
     *     isShowOpenPostsOnInvoices?: bool,
     *     isClosed?: bool,
     *     deliveryAddress?: int,
     *     deliveryComment?: string,
     *     isPrioritizeAmountsIncludingVat?: bool,
     *     orderLineSorting?: string,
     *     orderGroups?: array,
     *     orderLines?: array,
     *     isSubscription?: bool,
     *     subscriptionDuration?: int,
     *     subscriptionDurationType?: string,
     *     subscriptionPeriodsOnInvoice?: int,
     *     subscriptionInvoicingTimeInAdvanceOrArrears?: string,
     *     subscriptionInvoicingTime?: int,
     *     subscriptionInvoicingTimeType?: string,
     *     isSubscriptionAutoInvoicing?: bool,
     *     invoiceOnAccountVatHigh?: bool,
     *     invoiceSMSNotificationNumber?: string,
     *     markUpOrderLines?: float,
     *     discountPercentage?: float,
     *     travelReports?: array,
     *     accountingDimensionValues?: array,
     * } $data
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
     * @param array{
     *     version?: int,
     *     customer?: int,
     *     orderDate?: string,
     *     deliveryDate?: string,
     *     contact?: int,
     *     attn?: int,
     *     receiverEmail?: string,
     *     overdueNoticeEmail?: string,
     *     number?: string,
     *     reference?: string,
     *     contractReference?: string,
     *     ourContact?: int,
     *     ourContactEmployee?: int,
     *     department?: int,
     *     project?: int,
     *     invoiceComment?: string,
     *     internalComment?: string,
     *     currency?: int,
     *     invoicesDueIn?: int,
     *     invoicesDueInType?: string,
     *     isShowOpenPostsOnInvoices?: bool,
     *     isClosed?: bool,
     *     deliveryAddress?: int,
     *     deliveryComment?: string,
     *     isPrioritizeAmountsIncludingVat?: bool,
     *     orderLineSorting?: string,
     *     orderGroups?: array,
     *     orderLines?: array,
     *     isSubscription?: bool,
     *     subscriptionDuration?: int,
     *     subscriptionDurationType?: string,
     *     subscriptionPeriodsOnInvoice?: int,
     *     subscriptionInvoicingTimeInAdvanceOrArrears?: string,
     *     subscriptionInvoicingTime?: int,
     *     subscriptionInvoicingTimeType?: string,
     *     isSubscriptionAutoInvoicing?: bool,
     *     invoiceOnAccountVatHigh?: bool,
     *     invoiceSMSNotificationNumber?: string,
     *     markUpOrderLines?: float,
     *     discountPercentage?: float,
     *     travelReports?: array,
     *     accountingDimensionValues?: array,
     * } $data
     * @throws TripletexException
     */
    public function update(int $id, array $data): Order|ErrorResponse
    {
        return $this->updateResource(
            model: Order::make($data),
            path: [self::PATH, $id],
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

    /* OrderGroups
     * order/orderGroup
     * */

    /**
     * @param array{
     *     order: int,
     *     title?: string,
     *     comment?: string,
     *     sortIndex?: int,
     *     orderLines?: list<array{
     *         product?: int,
     *         inventory?: int,
     *         inventoryLocation?: int,
     *         description?: string,
     *         count?: float,
     *         unitCostCurrency?: float,
     *         unitPriceExcludingVatCurrency?: float,
     *         unitPriceIncludingVatCurrency?: float,
     *         currency?: int,
     *         markup?: float,
     *         discount?: float,
     *         vatType?: int,
     *         vendor?: int,
     *         isSubscription?: bool,
     *         subscriptionPeriodStart?: string,
     *         subscriptionPeriodEnd?: string,
     *         sortIndex?: int,
     *         isPicked?: bool,
     *         pickedDate?: string,
     *         orderedQuantity?: float,
     *         isCharged?: bool,
     *     }>,
     * } $data
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
}
