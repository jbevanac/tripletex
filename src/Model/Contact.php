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
        public ?int $id = null,
        public ?string $url = null,
        public ?string $firstName = null,
        public ?string $lastName = null,
        public ?string $displayName = null,
        public ?string $email = null,
        public ?Reference $phoneNumberMobileCountry = null,
        public ?string $phoneNumberMobile = null,
        public ?string $phoneNumberWork = null,
        public ?Reference $customer = null,
        public ?array $department = null,
        public readonly ?bool $isInactive = null,
    ) {
    }

}
