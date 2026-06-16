<?php

namespace Tripletex\Tests\Integration;

use Tripletex\Model\ListResponse;
use Tripletex\Model\Order;
use Tripletex\Model\OrderLine;
use Tripletex\Reference;
use Tripletex\Tests\TestCase;

class OrderTest extends TestCase
{
    private static ?int $createdId = null;

    public function test_list_returns_list_response(): void
    {
        $this->skipIfNoCredentials();

        // The Tripletex order list endpoint requires a date range
        $result = $this->sdkFromEnv()->orders()->list([
            'orderDateFrom' => date('Y-m-d', strtotime('-1 year')),
            'orderDateTo' => date('Y-m-d'),
        ]);

        $this->assertInstanceOf(ListResponse::class, $result);
    }

    public function test_create_returns_order_with_id(): void
    {
        $this->skipIfNoCredentials();

        $sdk = $this->sdkFromEnv();

        $customers = $sdk->customers()->list();
        if ($customers->values->count() === 0) {
            $this->markTestSkipped('No customers in account to create an order against');
        }

        $customerId = $customers->values->first()->id;

        $order = $sdk->orders()->create([
            'customer' => new Reference($customerId),
            'orderDate' => date('Y-m-d'),
            'deliveryDate' => date('Y-m-d', strtotime('+7 days')),
            'orderLines' => [
                new OrderLine(description: 'SDK Test Item', count: 1, unitPriceExcludingVatCurrency: 100),
            ],
        ]);

        $this->assertInstanceOf(Order::class, $order);
        $this->assertNotNull($order->id);

        self::$createdId = $order->id;
    }

    public function test_find_returns_order(): void
    {
        $this->skipIfNoCredentials();

        if (self::$createdId === null) {
            $this->markTestSkipped('Requires test_create_returns_order_with_id to run first');
        }

        $order = $this->sdkFromEnv()->orders()->find(self::$createdId);

        $this->assertInstanceOf(Order::class, $order);
        $this->assertSame(self::$createdId, $order->id);
    }
}
