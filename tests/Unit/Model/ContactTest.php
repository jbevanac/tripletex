<?php

namespace Tripletex\Tests\Unit\Model;

use Tripletex\Model\Contact;
use Tripletex\Tests\TestCase;

class ContactTest extends TestCase
{
    public function test_constructor_defaults_are_null(): void
    {
        $contact = new Contact();

        $this->assertNull($contact->id);
        $this->assertNull($contact->firstName);
        $this->assertNull($contact->lastName);
        $this->assertNull($contact->email);
    }

    public function test_make_maps_fields(): void
    {
        $contact = Contact::make([
            'firstName' => 'Jane',
            'lastName' => 'Doe',
            'email' => 'jane@example.com',
            'phoneNumberMobile' => '+4791234567',
            'isInactive' => false,
        ]);

        $this->assertInstanceOf(Contact::class, $contact);
        $this->assertSame('Jane', $contact->firstName);
        $this->assertSame('Doe', $contact->lastName);
        $this->assertSame('jane@example.com', $contact->email);
        $this->assertSame('+4791234567', $contact->phoneNumberMobile);
        $this->assertFalse($contact->isInactive);
    }

    public function test_make_unwraps_value_key(): void
    {
        $contact = Contact::make([
            'value' => ['firstName' => 'John', 'lastName' => 'Smith'],
        ]);

        $this->assertSame('John', $contact->firstName);
        $this->assertSame('Smith', $contact->lastName);
    }

    public function test_to_json_excludes_null_fields(): void
    {
        $contact = new Contact(firstName: 'Jane', lastName: 'Doe');
        $json = json_decode($contact->toJson(), true);

        $this->assertArrayHasKey('firstName', $json);
        $this->assertArrayHasKey('lastName', $json);
        $this->assertArrayNotHasKey('id', $json);
        $this->assertArrayNotHasKey('email', $json);
    }

    public function test_to_json_round_trip(): void
    {
        $contact = new Contact(
            id: 42,
            firstName: 'Jane',
            lastName: 'Doe',
            email: 'jane@example.com',
        );

        $json = $contact->toJson();
        $decoded = json_decode($json, true);

        $this->assertSame(42, $decoded['id']);
        $this->assertSame('Jane', $decoded['firstName']);
        $this->assertSame('jane@example.com', $decoded['email']);
    }
}
