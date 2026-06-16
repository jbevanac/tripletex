<?php

namespace Tripletex\Tests\Unit\Model;

use Tripletex\Enum\InvoiceSendMethod;
use Tripletex\Enum\Language;
use Tripletex\Model\Customer;
use Tripletex\Tests\TestCase;

class CustomerTest extends TestCase
{
    public function test_constructor_defaults_are_null(): void
    {
        $customer = new Customer();

        $this->assertNull($customer->id);
        $this->assertNull($customer->name);
        $this->assertNull($customer->email);
    }

    public function test_make_maps_fields(): void
    {
        $customer = Customer::make([
            'name' => 'Acme AS',
            'email' => 'billing@acme.no',
            'organizationNumber' => '123456789',
            'invoicesDueIn' => 30,
        ]);

        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertSame('Acme AS', $customer->name);
        $this->assertSame('billing@acme.no', $customer->email);
        $this->assertSame('123456789', $customer->organizationNumber);
        $this->assertSame(30, $customer->invoicesDueIn);
    }

    public function test_make_maps_enum_fields(): void
    {
        $customer = Customer::make([
            'name' => 'Test',
            'language' => 'NO',
            'invoiceSendMethod' => 'EMAIL',
        ]);

        $this->assertSame(Language::NO, $customer->language);
        $this->assertSame(InvoiceSendMethod::EMAIL, $customer->invoiceSendMethod);
    }

    public function test_to_json_excludes_null_fields(): void
    {
        $customer = new Customer(name: 'Acme AS');
        $json = json_decode($customer->toJson(), true);

        $this->assertArrayHasKey('name', $json);
        $this->assertArrayNotHasKey('id', $json);
        $this->assertArrayNotHasKey('email', $json);
    }

    public function test_to_json_round_trip(): void
    {
        $customer = new Customer(
            id: 99,
            name: 'Acme AS',
            email: 'billing@acme.no',
            invoicesDueIn: 14,
        );

        $decoded = json_decode($customer->toJson(), true);

        $this->assertSame(99, $decoded['id']);
        $this->assertSame('Acme AS', $decoded['name']);
        $this->assertSame(14, $decoded['invoicesDueIn']);
    }
}
