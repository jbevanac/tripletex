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
        public ?int $id,
        public ?string $name,
        public readonly ?string $url,
        public ?string $displayName,
        public ?int $customerNumber,
        public ?bool $isPrivateIndividual,
        public ?string $email,
        public ?string $invoiceEmail,
        public ?string $overdueNoticeEmail,
        public ?string $organizationNumber,
        public ?string $phoneNumber,
        public ?string $phoneNumberMobile,
        public ?Language $language,
        public ?InvoiceSendMethod $invoiceSendMethod,
        public ?EmailAttachmentType $emailAttachmentType,
        public ?int $invoicesDueIn,
        public ?invoicesDueInType $invoicesDueInType,
        public ?Address $postalAddress,
        public ?Address $physicalAddress,
    ) {
    }

}
