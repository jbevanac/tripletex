<?php

namespace Tripletex\Model;

use Tripletex\Contracts\ModelInterface;
use Tripletex\Enum\SubscriptionInvoicingTimeInAdvanceOrArrears;
use Tripletex\Reference;

final class OrderLine implements ModelInterface
{
    use ModelTrait;

    public function __construct(
        public ?Reference $order = null,
        public ?string $description = null,
        public ?float $count = null,
        public ?float $unitPriceExcludingVatCurrency = null,
        public ?bool $isSubscription = null,
        public ?string $subscriptionPeriodStart = null,
        public ?string $subscriptionPeriodEnd = null,
        public ?bool $isSubscriptionAutoInvoicing = null,
        public ?SubscriptionInvoicingTimeInAdvanceOrArrears $subscriptionInvoicingTimeInAdvanceOrArrears = null,
        public ?int $subscriptionInvoicingTime = null,
    ) {
    }

}
