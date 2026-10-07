<?php

namespace Tripletex\Model;

use Tripletex\Contracts\ModelInterface;

final class Address implements ModelInterface
{
    use ModelTrait;

    public function __construct(
        public ?int $id = null,
        public ?string $url = null,
        public ?string $addressLine1 = null,
        public ?string $addressLine2 = null,
        public ?string $postalCode = null,
        public ?string $city = null,
        public ?Country $country = null,
        public readonly ?string $displayName = null,
        public readonly ?string $addressAsString = null,
        public readonly ?string $displayNameInklMatrikkel = null,
        public ?int $knr = null,
        public ?int $gnr = null,
        public ?int $bnr = null,
        public ?int $fnr = null,
        public ?int $snr = null,
        public ?string $unitNumber = null,
    ) {
    }
}
