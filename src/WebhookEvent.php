<?php

namespace Tripletex;

use Tripletex\Exceptions\Configuration\AuthenticationException;
use Tripletex\Exceptions\SerializerException;
use Tripletex\Exceptions\TripletexException;

final readonly class WebhookEvent
{
    public function __construct(
        private int $subscriptionId,
        private string $eventType,
        private int|string $objectId,
        private ?array $value,
        private array $rawPayload,
    ) {
    }

    /**
     * @throws SerializerException
     * @throws AuthenticationException
     */
    public static function fromPayload(string $payload, ?string $expected, ?string $received): self
    {
        self::authenticate($expected, $received);

        try {
            $payload = json_decode($payload, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new SerializerException('Invalid Tripletex webhook payload');
        }

        if (!isset($payload['event'], $payload['id'])) {
            throw new \InvalidArgumentException('Invalid Tripletex webhook payload');
        }

        return new self(
            subscriptionId: (int) ($payload['subscriptionId'] ?? 0),
            eventType: (string) $payload['event'],
            objectId: $payload['id'],
            value: $payload['value'] ?? null,
            rawPayload: $payload
        );
    }

    /**
     * @throws AuthenticationException
     */
    private static function authenticate(string $expected, $received): void
    {
        if (!hash_equals($expected, $received)) {
            throw new AuthenticationException('Failed to authenticate webhook');
        }
    }

    public function getSubscriptionId(): int
    {
        return $this->subscriptionId;
    }

    public function getEventType(): string
    {
        return $this->eventType;
    }

    public function getObjectId(): int|string
    {
        return $this->objectId;
    }

    /**
     * Stable idempotency key for event logging
     */
    public function getEventId(): string
    {
        return sprintf('%s:%s', $this->eventType, $this->objectId);
    }

    public function getValue(): ?array
    {
        return $this->value;
    }

    public function getRawPayload(): array
    {
        return $this->rawPayload;
    }

    public function isDelete(): bool
    {
        return str_ends_with($this->eventType, '.delete');
    }

    public function getObjectType(): string
    {
        return explode('.', $this->eventType, 2)[0];
    }

    public function getVerb(): string
    {
        return explode('.', $this->eventType, 2)[1] ?? '';
    }
}