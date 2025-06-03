<?php

namespace Tripletex\Model;

use Tripletex\Contracts\ModelInterface;
use Tripletex\Enum\EmailAttachmentType;
use Tripletex\Enum\invoicesDueInType;
use Tripletex\Enum\InvoiceSendMethod;
use Tripletex\Enum\Language;
use Tripletex\Reference;

final class Contact implements ModelInterface
{
    use ModelTrait;

    public function __construct(
        public ?int $id,
        public readonly ?string $url,
        public ?string $firstName,
        public ?string $lastName,
        public ?string $displayName,
        public ?string $email,
        public ?Reference $phoneNumberMobileCountry,
        public ?string $phoneNumberMobile,
        public ?string $phoneNumberWork,
        public ?Reference $customer,
        public ?array $department,
        public readonly ?bool $isInactive,
    ) {
    }

}
