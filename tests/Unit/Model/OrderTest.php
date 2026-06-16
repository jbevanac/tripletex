<?php

namespace Tripletex\Tests\Unit\Model;

use Tripletex\Model\Customer;
use Tripletex\Model\Order;
use Tripletex\Model\OrderLine;
use Tripletex\Tests\TestCase;

class OrderTest extends TestCase
{
    public function test_make_maps_basic_fields(): void
    {
        $order = Order::make([
            'orderDate' => '2025-06-01',
            'deliveryDate' => '2025-06-15',
        ]);

        $this->assertInstanceOf(Order::class, $order);
        $this->assertSame('2025-06-01', $order->orderDate);
        $this->assertSame('2025-06-15', $order->deliveryDate);
    }

    public function test_order_line_constructor(): void
    {
        $line = new OrderLine(
            description: 'Consulting',
            count: 2,
            unitPriceExcludingVatCurrency: 1500.0,
        );

        $this->assertSame('Consulting', $line->description);
        $this->assertSame(2.0, $line->count);
        $this->assertSame(1500.0, $line->unitPriceExcludingVatCurrency);
    }

    public function test_order_with_order_lines_serializes(): void
    {
        $order = new Order(
            customer: new Customer(id: 99),
            orderDate: '2025-06-01',
            orderLines: [
                new OrderLine(description: 'Item A', count: 1, unitPriceExcludingVatCurrency: 500),
                new OrderLine(description: 'Item B', count: 3, unitPriceExcludingVatCurrency: 100),
            ],
        );

        $json = json_decode($order->toJson(), true);

        $this->assertSame('2025-06-01', $json['orderDate']);
        $this->assertSame(99, $json['customer']['id']);
        $this->assertCount(2, $json['orderLines']);
        $this->assertSame('Item A', $json['orderLines'][0]['description']);
    }

    public function test_to_json_excludes_null_fields(): void
    {
        $order = new Order(orderDate: '2025-06-01');
        $json = json_decode($order->toJson(), true);

        $this->assertArrayHasKey('orderDate', $json);
        $this->assertArrayNotHasKey('id', $json);
        $this->assertArrayNotHasKey('deliveryDate', $json);
    }
}
