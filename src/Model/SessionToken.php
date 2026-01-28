<?php

namespace Tripletex\Model;

use Tripletex\Contracts\ModelInterface;

final class SessionToken implements ModelInterface
{
    use ModelTrait;

    public function __construct(
        public ?int $id,
        public ?int $version,
        public ?string $expirationDate,
        public ?string $token,
        public ?string $encryptionKey,
    ) {
    }
}
