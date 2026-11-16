<?php

namespace Tripletex\Model;

use Tripletex\Contracts\ModelInterface;
use Tripletex\Reference;

/** A bilag: a dated set of postings that must balance to zero. */
final class Voucher implements ModelInterface
{
    use ModelTrait;

    public function __construct(
        public ?int $id = null,
        public ?int $version = null,
        public ?string $url = null,
        public ?string $date = null,
        public ?string $description = null,
        public ?int $number = null,
        public ?int $tempNumber = null,
        public ?int $year = null,
        public ?string $externalVoucherNumber = null,
        public ?Reference $voucherType = null,
        /** @var Posting[]|null */
        public ?array $postings = null,
        public ?Reference $attachment = null,
        public ?bool $wasAutoMatched = null,
    ) {
    }
}
