<?php

namespace Tripletex\DTO;

final class Customer
{
    use Model;

    public function __construct(
        public ?int $id,
        public string $name,
        public ?string $email,
        public ?int $customerNumber,
        public ?string $organizationNumber,
        public ?string $invoiceEmail,
    ) {
    }

}
