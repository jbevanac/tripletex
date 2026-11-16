<?php

namespace Tripletex\Model;

use Tripletex\Contracts\ModelInterface;
use Tripletex\Reference;

/**
 * One line of a voucher. A positive amount is a debit, a negative one a credit.
 * With a vat type, amountGross includes VAT and Tripletex adds the VAT posting itself (as row 0).
 */
final class Posting implements ModelInterface
{
    use ModelTrait;

    public function __construct(
        public ?int $id = null,
        public ?int $version = null,
        public ?int $row = null,
        public ?string $date = null,
        public ?string $description = null,
        public ?Account $account = null,
        public ?VatType $vatType = null,
        public ?float $amount = null,
        public ?float $amountCurrency = null,
        public ?float $amountGross = null,
        public ?float $amountGrossCurrency = null,
        public ?Reference $currency = null,
        public ?Customer $customer = null,
        public ?Reference $supplier = null,
        public ?Reference $department = null,
        public ?Reference $project = null,
        public ?string $invoiceNumber = null,
        public ?string $termOfPayment = null,
        public ?bool $systemGenerated = null,
    ) {
    }
}
