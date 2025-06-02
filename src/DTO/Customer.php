<?php

namespace Tripletex\DTO;

use Tripletex\Contracts\ModelInterface;
use Tripletex\Enum\EmailAttachmentType;
use Tripletex\Enum\invoicesDueInType;
use Tripletex\Enum\InvoiceSendMethod;

final class Customer implements ModelInterface
{
    use DTOTrait;

    public function __construct(
        public ?int $id,
        public string $name,
        public ?string $email,
        public ?int $customerNumber,
        public ?string $organizationNumber,
        public ?string $invoiceEmail,
        public ?InvoiceSendMethod $invoiceSendMethod,
        public ?EmailAttachmentType $emailAttachmentType,
        public ?int $invoicesDueIn,
        public ?invoicesDueInType $invoicesDueInType,
    ) {
    }

}
