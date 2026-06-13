<?php

namespace Tripletex\Model;

use Tripletex\Contracts\ModelInterface;
use Tripletex\Reference;

final class OrderGroup implements ModelInterface
{
    use ModelTrait;

    public function __construct(
        public ?int $id = null,
        public ?int $version = null,
        public ?array $changes = null,
        public ?string $url = null,
        public ?Reference $order = null,
        public ?string $title = null,
        public ?string $comment = null,
        public ?int $sortIndex = null,
        /** @var OrderLine[]|null */
        public ?array $orderLines = null,
    ) {
    }
}
