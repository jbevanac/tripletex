<?php

namespace Tripletex\Tests\Integration;

use Tripletex\Model\Country;
use Tripletex\Tests\TestCase;

class CountryTest extends TestCase
{
    public function test_find_by_iso_code_returns_country(): void
    {
        $this->skipIfNoCredentials();

        $country = $this->sdkFromEnv()->countries()->findByIsoCode('se');

        $this->assertInstanceOf(Country::class, $country);
        $this->assertSame('SE', $country->isoAlpha2Code);
    }

    public function test_find_by_iso_code_returns_null_for_unknown_code(): void
    {
        $this->skipIfNoCredentials();

        $this->assertNull($this->sdkFromEnv()->countries()->findByIsoCode('XX'));
    }

    public function test_foreign_customer_accepts_foreign_organization_number(): void
    {
        $this->skipIfNoCredentials();

        $sdk = $this->sdkFromEnv();
        $sweden = $sdk->countries()->findByIsoCode('SE');

        $customer = $sdk->customers()->create([
            'name' => 'SDK Foreign Customer '.uniqid(),
            'organizationNumber' => '5560360793',
            'postalAddress' => ['country' => ['id' => $sweden->id]],
            'physicalAddress' => ['country' => ['id' => $sweden->id]],
        ]);

        $this->assertNotNull($customer->id ?? null, json_encode($customer));
    }
}
