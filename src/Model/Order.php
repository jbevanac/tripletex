<?php

namespace Tripletex\Model;

use Tripletex\Contracts\ModelInterface;
use Tripletex\Enum\invoicesDueInType;
use Tripletex\Enum\Order\LineSorting;
use Tripletex\Enum\Order\Status;
use Tripletex\Enum\subscriptionDurationType;
use Tripletex\Enum\SubscriptionInvoicingTimeInAdvanceOrArrears;
use Tripletex\Enum\SubscriptionInvoicingTimeType;
use Tripletex\Enum\SubscriptionPeriodsOnInvoiceType;
use Tripletex\Reference;

final class Order implements ModelInterface
{
    use ModelTrait;

    public function __construct(
        public ?Customer $customer = null,
        public ?string $orderDate = null,
        public ?string $deliveryDate = null,
        public ?int $id = null,
        public ?int $version = null,
        public ?array $changes = null,
        public ?string $url = null,
        public ?Contact $contact = null,
        public ?Contact $attn = null,
        public ?string $displayName = null,
        public ?string $receiverEmail = null,
        public ?string $overdueNoticeEmail = null,
        public ?string $number = null,
        public ?string $reference = null,
        public ?string $contractReference = null,
        public ?Contact $ourContact = null,
        public ?Employee $ourContactEmployee = null,
        public ?Reference $department = null,
        public ?Reference $project = null,
        public ?string $invoiceComment = null,
        public ?string $internalComment = null,
        public ?Reference $currency = null,
        public ?int $invoicesDueIn = null,
        public ?invoicesDueInType $invoicesDueInType = null,
        public ?Status $status = null,
        public ?bool $isShowOpenPostsOnInvoices = null,
        public ?bool $isClosed = null,
        public ?Reference $deliveryAddress = null,
        public ?string $deliveryComment = null,
        public ?bool $isPrioritizeAmountsIncludingVat = null,
        public ?LineSorting $orderLineSorting = null,
        /** @var OrderGroup[]|null */
        public ?array $orderGroups = null,
        /** @var OrderLine[]|null */
        public ?array $orderLines = null,
        public ?bool $isSubscription = null,
        public ?int $subscriptionDuration = null,
        public ?subscriptionDurationType $subscriptionDurationType = null,
        public ?int $subscriptionPeriodsOnInvoice = null,
        public ?SubscriptionPeriodsOnInvoiceType $subscriptionPeriodsOnInvoiceType = null,
        public ?SubscriptionInvoicingTimeInAdvanceOrArrears $subscriptionInvoicingTimeInAdvanceOrArrears = null,
        public ?int $subscriptionInvoicingTime = null,
        public ?SubscriptionInvoicingTimeType $subscriptionInvoicingTimeType = null,
        public ?bool $isSubscriptionAutoInvoicing = null,
        public ?Invoice $preliminaryInvoice = null,
        public ?array $attachment = null,
        public ?array $attachmentRelation = null,
        public ?string $sendMethodDescription = null,
        public ?bool $canCreateBackorder = null,
        public ?int $backorderParentId = null,
        public ?bool $invoiceOnAccountVatHigh = null,
        public ?float $totalInvoicedOnAccountAmountAbsoluteCurrency = null,
        public ?bool $invoiceSendSMSNotification = null,
        public ?string $invoiceSMSNotificationNumber = null,
        public ?float $markUpOrderLines = null,
        public ?float $discountPercentage = null,
        public ?string $customerName = null,
        public ?string $projectManagerNameAndNumber = null,
        public ?array $travelReports = null,
        public ?array $accountingDimensionValues = null,
    ) {
    }
}
