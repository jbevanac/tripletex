<?php

namespace Tripletex\Model;

use Tripletex\Contracts\ModelInterface;
use Tripletex\Reference;

final class Contact implements ModelInterface
{
    use ModelTrait;

    public function __construct(
        public ?int $id = null,
        public ?int $version = null,
        public ?string $url = null,
        public ?string $firstName = null,
        public ?string $lastName = null,
        public ?string $displayName = null,
        public ?string $email = null,
        public ?Reference $phoneNumberMobileCountry = null,
        public ?string $phoneNumberMobile = null,
        public ?string $phoneNumberWork = null,
        public ?Reference $customer = null,
        public ?Reference $department = null,
        public ?bool $isInactive = null,
    ) {
    }
}
