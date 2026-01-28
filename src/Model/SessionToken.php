<?php

namespace Tripletex\Model;

use Tripletex\Contracts\ModelInterface;

final class SessionToken implements ModelInterface
{
    public function __construct(
        public ?int $id,
        public ?int $version,
        public ?string $expirationDate,
        public ?string $token,
        public ?string $encryptionKey,
    ) {
    }

    public function toJson(): string
    {
        return json_encode([
            'id' => $this->id,
            'version' => $this->version,
            'expirationDate' => $this->expirationDate,
            'token' => $this->token,
            'encryptionKey' => $this->encryptionKey,
        ]);
    }

    public static function make(array $data): SessionToken
    {
        return new self(
            id: $data['id'],
            version: $data['version'],
            expirationDate: $data['expirationDate'],
            token: $data['token'],
            encryptionKey: $data['encryptionKey'],
        );
    }
}
