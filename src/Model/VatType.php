<?php

namespace Tripletex\Model;

use Tripletex\Contracts\ModelInterface;
use Tripletex\Enum\SubscriptionInvoicingTimeInAdvanceOrArrears;
use Tripletex\Reference;

final class VatType implements ModelInterface
{
    use ModelTrait;

    public function __construct(
        public ?int $id = null,
        public ?string $name = null,
        public ?string $number = null,
        public ?string $displayName = null,
        public ?float $percentage = null,
        public ?float $deductionPercentage = null,
    ) {
    }
}
