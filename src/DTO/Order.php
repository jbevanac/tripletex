<?php

namespace Tripletex\DTO;

use Tripletex\Contracts\ModelInterface;
use Tripletex\Reference;

final class Order implements ModelInterface
{
    use DTOTrait;

    public const string CREATE_PATH = 'order';
    public const string LIST_PATH = 'order/list';

    public function __construct(
        public Reference $customer,
        public string $orderDate,
        public string $deliveryDate,
        public ?int $id = null,
        public ?bool $isSubscription = null,
        public ?array $orderLines = null,
    ) {
    }

}
