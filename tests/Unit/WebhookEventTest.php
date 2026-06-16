<?php

namespace Tripletex\Tests\Unit;

use Tripletex\Exceptions\SerializerException;
use Tripletex\Tests\TestCase;
use Tripletex\WebhookEvent;

class WebhookEventTest extends TestCase
{
    private string $samplePayload;

    protected function setUp(): void
    {
        $this->samplePayload = json_encode([
            'subscriptionId' => 7,
            'event' => 'employee.update',
            'id' => 123,
            'value' => ['id' => 123, 'firstName' => 'Jane'],
        ]);
    }

    public function test_from_payload_parses_fields(): void
    {
        $event = WebhookEvent::fromPayload($this->samplePayload);

        $this->assertSame(7, $event->getSubscriptionId());
        $this->assertSame('employee.update', $event->getEventType());
        $this->assertSame(123, $event->getObjectId());
        $this->assertSame(['id' => 123, 'firstName' => 'Jane'], $event->getValue());
    }

    public function test_get_object_type(): void
    {
        $event = WebhookEvent::fromPayload($this->samplePayload);

        $this->assertSame('employee', $event->getObjectType());
    }

    public function test_get_verb(): void
    {
        $event = WebhookEvent::fromPayload($this->samplePayload);

        $this->assertSame('update', $event->getVerb());
    }

    public function test_is_delete_false_for_update(): void
    {
        $event = WebhookEvent::fromPayload($this->samplePayload);

        $this->assertFalse($event->isDelete());
    }

    public function test_is_delete_true_for_delete_event(): void
    {
        $payload = json_encode([
            'subscriptionId' => 1,
            'event' => 'employee.delete',
            'id' => 99,
        ]);

        $event = WebhookEvent::fromPayload($payload);

        $this->assertTrue($event->isDelete());
    }

    public function test_from_payload_throws_on_invalid_json(): void
    {
        $this->expectException(SerializerException::class);

        WebhookEvent::fromPayload('not-json');
    }

    public function test_from_payload_throws_on_missing_required_fields(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        WebhookEvent::fromPayload(json_encode(['subscriptionId' => 1]));
    }

    public function test_missing_subscription_id_defaults_to_zero(): void
    {
        $payload = json_encode([
            'event' => 'customer.create',
            'id' => 55,
        ]);

        $event = WebhookEvent::fromPayload($payload);

        $this->assertSame(0, $event->getSubscriptionId());
    }
}
