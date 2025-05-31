<?php

namespace Tripletex\DTO;

use Tripletex\Contracts\ModelInterface;

class ErrorResponse implements ModelInterface
{
    use DTOTrait;

    public function __construct(
        public int $status,
        public int $code,
        public string $message,
        public ?string $link = null,
        public ?string $developerMessage = null,
        /** @var ValidationMessage[]|null */
        public ?array $validationMessages = null,
        public ?string $requestId = null,
    ) {}
}