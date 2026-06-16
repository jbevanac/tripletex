<?php

namespace Tripletex\Tests\Integration;

use Tripletex\Model\Contact;
use Tripletex\Model\ListResponse;
use Tripletex\Tests\TestCase;

class ContactTest extends TestCase
{
    private static ?int $createdId = null;

    public function test_list_returns_list_response(): void
    {
        $this->skipIfNoCredentials();

        $result = $this->sdkFromEnv()->contacts()->list();

        $this->assertInstanceOf(ListResponse::class, $result);
    }

    public function test_create_returns_contact_with_id(): void
    {
        $this->skipIfNoCredentials();

        $contact = $this->sdkFromEnv()->contacts()->create([
            'firstName' => 'SDK',
            'lastName' => 'Test ' . uniqid(),
        ]);

        $this->assertInstanceOf(Contact::class, $contact);
        $this->assertNotNull($contact->id);

        self::$createdId = $contact->id;
    }

    public function test_find_returns_contact(): void
    {
        $this->skipIfNoCredentials();

        if (self::$createdId === null) {
            $this->markTestSkipped('Requires test_create_returns_contact_with_id to run first');
        }

        $contact = $this->sdkFromEnv()->contacts()->find(self::$createdId);

        $this->assertInstanceOf(Contact::class, $contact);
        $this->assertSame(self::$createdId, $contact->id);
    }

    public function test_update_returns_updated_contact(): void
    {
        $this->skipIfNoCredentials();

        if (self::$createdId === null) {
            $this->markTestSkipped('Requires test_create_returns_contact_with_id to run first');
        }

        $updated = $this->sdkFromEnv()->contacts()->update(self::$createdId, [
            'firstName' => 'SDK',
            'lastName' => 'Updated',
            'email' => 'sdk-test@example.com',
        ]);

        $this->assertInstanceOf(Contact::class, $updated);
        $this->assertSame('Updated', $updated->lastName);
    }
}
