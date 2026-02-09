<?php

namespace Tripletex\Model;

use Tripletex\Contracts\ModelInterface;
use Tripletex\Enum\SubscriptionStatus;

final class Subscription implements ModelInterface
{
    use ModelTrait;

    public function __construct(
        public ?int $id = null,
        public ?int $version = null,
        public ?string $url = null,
        public ?string $event = null,
        public ?string $targetUrl = null,
        public ?string $fields = null,
        public ?SubscriptionStatus $status = null,
        public ?string $authHeaderName = null,
        public ?string $authHeaderValue = null,
        public ?string $hmacSharedSecret = null,
    ) {
    }
}
