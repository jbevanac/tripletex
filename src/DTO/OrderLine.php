<?php

namespace Tripletex\DTO;

use Tripletex\Contracts\ModelInterface;
use Tripletex\Reference;

final class OrderLine implements ModelInterface
{
    use DTOTrait;

    public function __construct(
        public ?Reference $order = null,
        public ?string $description = null,
        public ?float $count = null,
        public ?float $unitPriceExcludingVatCurrency = null,
    ) {
    }

}
