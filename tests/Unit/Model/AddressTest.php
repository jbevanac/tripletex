<?php

namespace Tripletex\Tests\Unit\Model;

use Tripletex\Model\Address;
use Tripletex\Model\Country;
use Tripletex\Model\Customer;
use Tripletex\Tests\TestCase;

class AddressTest extends TestCase
{
    public function test_constructor_defaults_are_null(): void
    {
        $address = new Address();

        $this->assertNull($address->id);
        $this->assertNull($address->country);
    }

    public function test_customer_address_serializes_country_as_reference(): void
    {
        $customer = new Customer(
            name: 'Acme AB',
            postalAddress: new Address(city: 'Stockholm', country: new Country(id: 191)),
        );

        $json = json_decode($customer->toJson(), true);

        $this->assertSame(['city' => 'Stockholm', 'country' => ['id' => 191]], $json['postalAddress']);
    }

    public function test_make_accepts_country_id_in_address(): void
    {
        $customer = Customer::make([
            'name' => 'Acme AB',
            'physicalAddress' => ['country' => 191],
        ]);

        $this->assertSame(191, $customer->physicalAddress->country->id);
    }
}
