<?php

namespace Tripletex\Model;

use Tripletex\Contracts\ModelInterface;
use Tripletex\Enum\EmailAttachmentType;
use Tripletex\Enum\invoicesDueInType;
use Tripletex\Enum\InvoiceSendMethod;
use Tripletex\Enum\Language;

final class Customer implements ModelInterface
{
    use ModelTrait;

    public function __construct(
        public ?int $id = null,
        public ?int $version = null,
        public ?string $url = null,
        public ?string $name = null,
        public ?string $displayName = null,
        public ?int $customerNumber = null,
        public ?bool $isPrivateIndividual = null,
        public ?string $email = null,
        public ?string $invoiceEmail = null,
        public ?string $overdueNoticeEmail = null,
        public ?string $organizationNumber = null,
        public ?string $phoneNumber = null,
        public ?string $phoneNumberMobile = null,
        public ?Language $language = null,
        public ?InvoiceSendMethod $invoiceSendMethod = null,
        public ?EmailAttachmentType $emailAttachmentType = null,
        public ?int $invoicesDueIn = null,
        public ?invoicesDueInType $invoicesDueInType = null,
        public ?Address $postalAddress = null,
        public ?Address $physicalAddress = null,
    ) {
    }
}
