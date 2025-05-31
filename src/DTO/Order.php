<?php

namespace Tripletex\DTO;

use Tripletex\Contracts\ModelInterface;
use Tripletex\Reference;

final class Order implements ModelInterface
{
    use DTOTrait;

    public const string CREATE_PATH = 'order';

    public function __construct(
        public ?int $id,
        public Reference $customer,
        public string $orderDate,
        public string $deliveryDate
    ) {
    }

}
