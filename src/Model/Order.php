<?php

namespace Tripletex\Model;

use Tripletex\Contracts\ModelInterface;
use Tripletex\Enum\subscriptionDurationType;
use Tripletex\Reference;

final class Order implements ModelInterface
{
    use ModelTrait;

    public function __construct(
        public ?Reference $customer,
        public ?string $orderDate,
        public ?string $deliveryDate,
        public ?int $id = null,
        public ?array $orderGroups = null,
        public ?array $orderLines = null,
        public ?bool $isSubscription = null,
        public ?int $subscriptionDuration = null,
        public ?int $subscriptionPeriodsOnInvoice = null,
        public ?SubscriptionDurationType $subscriptionDurationType = null,
    ) {
    }
}
