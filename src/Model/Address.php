<?php

namespace Tripletex\Model;

use Tripletex\Contracts\ModelInterface;
use Tripletex\Enum\EmailAttachmentType;
use Tripletex\Enum\invoicesDueInType;
use Tripletex\Enum\InvoiceSendMethod;
use Tripletex\Enum\Language;
use Tripletex\Reference;

final class Address implements ModelInterface
{
    use ModelTrait;

    public function __construct(
        public ?int $id,
        public ?string $url,
        public ?string $addressLine1,
        public ?string $addressLine2,
        public ?string $postalCode,
        public ?string $city,
        public ?array $country,
        public readonly ?string $displayName,
        public readonly ?string $addressAsString,
        public readonly ?string $displayNameInklMatrikkel,
        public ?int $knr,
        public ?int $gnr,
        public ?int $bnr,
        public ?int $fnr,
        public ?int $snr,
        public ?string $unitNumber,
    ) {
    }

}
