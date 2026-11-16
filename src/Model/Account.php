<?php

namespace Tripletex\Model;

use Tripletex\Contracts\ModelInterface;

/** A ledger account in the chart of accounts (e.g. 3000 Salgsinntekt). */
final class Account implements ModelInterface
{
    use ModelTrait;

    public function __construct(
        public ?int $id = null,
        public ?int $version = null,
        public ?int $number = null,
        public ?string $name = null,
        public ?string $description = null,
        public ?string $type = null,
        public ?VatType $vatType = null,
        public ?bool $vatLocked = null,
        public ?bool $isInactive = null,
        public ?bool $isBankAccount = null,
        public ?bool $requireReconciliation = null,
    ) {
    }
}
