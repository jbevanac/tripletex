<?php

namespace Tripletex\Model;

use Tripletex\Contracts\ModelInterface;

final class ValidationMessage implements ModelInterface
{
    use ModelTrait;

    public function __construct(
        public string $field,
        public string $message,
    ) {}
}
