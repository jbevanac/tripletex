<?php

namespace Tripletex\DTO;

use Tripletex\Contracts\ModelInterface;
use Tripletex\Reference;

final class OrderLine implements ModelInterface
{
    use DTOTrait;

    public const string CREATE_PATH = 'order';

    public function __construct(
        public ?Reference $order = null,
        public ?string $description = null,
        public ?float $count = null,
        public ?float $unitPriceExcludingVatCurrency = null,
    ) {
    }

}
