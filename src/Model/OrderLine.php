<?php

namespace Tripletex\Model;

use Tripletex\Contracts\ModelInterface;
use Tripletex\Reference;

final class OrderLine implements ModelInterface
{
    use ModelTrait;

    public function __construct(
        public ?int $id = null,
        public ?int $version = null,
        public ?array $changes = null,
        public ?string $url = null,
        public ?Reference $product = null,
        public ?Reference $inventory = null,
        public ?Reference $inventoryLocation = null,
        public ?string $description = null,
        public ?string $displayName = null,
        public ?float $count = null,
        public ?float $unitCostCurrency = null,
        public ?float $unitPriceExcludingVatCurrency = null,
        public ?Reference $currency = null,
        public ?float $markup = null,
        public ?float $discount = null,
        public ?VatType $vatType = null,
        public ?float $amountExcludingVatCurrency = null,
        public ?float $amountIncludingVatCurrency = null,
        public ?Reference $vendor = null,
        public ?Reference $order = null,
        public ?float $unitPriceIncludingVatCurrency = null,
        public ?bool $isSubscription = null,
        public ?string $subscriptionPeriodStart = null,
        public ?string $subscriptionPeriodEnd = null,
        public ?Reference $orderGroup = null,
        public ?int $sortIndex = null,
        public ?bool $isPicked = null,
        public ?string $pickedDate = null,
        public ?float $orderedQuantity = null,
        public ?bool $isCharged = null,
        public ?float $originalOrderedQuantity = null,
        public ?float $deliveredQuantity = null,
    ) {
    }
}
