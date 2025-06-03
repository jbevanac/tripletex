<?php

namespace Tripletex\Model;

use Tripletex\Contracts\ModelInterface;
use Tripletex\Enum\EmailAttachmentType;
use Tripletex\Enum\invoicesDueInType;
use Tripletex\Enum\InvoiceSendMethod;
use Tripletex\Enum\Language;
use Tripletex\Reference;

final class Country implements ModelInterface
{
    use ModelTrait;

    public function __construct(
        public readonly ?int $id,
        public readonly ?string $url,
        public readonly ?string $name,
        public readonly ?string $displayName,
        public readonly ?string $isoAlpha2Code,
        public readonly ?string $isoAlpha3Code,
        public readonly ?string $isoNumericCode,
    ) {
    }
}
