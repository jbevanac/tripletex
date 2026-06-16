<?php

namespace Tripletex\Tests\Integration;

use Tripletex\Model\Customer;
use Tripletex\Model\ListResponse;
use Tripletex\Tests\TestCase;

class CustomerTest extends TestCase
{
    private static ?int $createdId = null;

    public function test_list_returns_list_response(): void
    {
        $this->skipIfNoCredentials();

        $result = $this->sdkFromEnv()->customers()->list();

        $this->assertInstanceOf(ListResponse::class, $result);
    }

    public function test_create_returns_customer_with_id(): void
    {
        $this->skipIfNoCredentials();

        $customer = $this->sdkFromEnv()->customers()->create([
            'name' => 'SDK Test Customer ' . uniqid(),
        ]);

        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertNotNull($customer->id);

        self::$createdId = $customer->id;
    }

    public function test_find_returns_customer(): void
    {
        $this->skipIfNoCredentials();

        if (self::$createdId === null) {
            $this->markTestSkipped('Requires test_create_returns_customer_with_id to run first');
        }

        $customer = $this->sdkFromEnv()->customers()->find(self::$createdId);

        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertSame(self::$createdId, $customer->id);
    }

    public function test_update_returns_updated_customer(): void
    {
        $this->skipIfNoCredentials();

        if (self::$createdId === null) {
            $this->markTestSkipped('Requires test_create_returns_customer_with_id to run first');
        }

        $newName = 'SDK Updated Customer ' . uniqid();
        $updated = $this->sdkFromEnv()->customers()->update(self::$createdId, ['name' => $newName]);

        $this->assertInstanceOf(Customer::class, $updated);
        $this->assertSame($newName, $updated->name);
    }
}
