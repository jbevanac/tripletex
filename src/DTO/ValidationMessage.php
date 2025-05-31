<?php

namespace Tripletex\DTO;

use Tripletex\Contracts\ModelInterface;

final class ValidationMessage implements ModelInterface
{
    use DTOTrait;

    public function __construct(
        public string $field,
        public string $message,
    ) {}
}
