<?php

namespace Tripletex\Tests\Integration;

use Tripletex\Model\Invoice;
use Tripletex\Model\ListResponse;
use Tripletex\Tests\TestCase;

class InvoiceTest extends TestCase
{
    public function test_list_returns_list_response(): void
    {
        $this->skipIfNoCredentials();

        // The Tripletex invoice list endpoint requires a date range
        $result = $this->sdkFromEnv()->invoices()->list([
            'invoiceDateFrom' => date('Y-m-d', strtotime('-1 year')),
            'invoiceDateTo' => date('Y-m-d'),
        ]);

        $this->assertInstanceOf(ListResponse::class, $result);
    }

    public function test_list_values_are_invoice_instances(): void
    {
        $this->skipIfNoCredentials();

        $result = $this->sdkFromEnv()->invoices()->list([
            'invoiceDateFrom' => date('Y-m-d', strtotime('-1 year')),
            'invoiceDateTo' => date('Y-m-d'),
        ]);

        $this->assertInstanceOf(ListResponse::class, $result);

        if ($result->values === null || $result->values->count() === 0) {
            $this->markTestSkipped('No invoices in the last year to assert on');
        }

        $this->assertInstanceOf(Invoice::class, $result->values->first());
    }

    public function test_find_returns_invoice(): void
    {
        $this->skipIfNoCredentials();

        $sdk = $this->sdkFromEnv();
        $list = $sdk->invoices()->list([
            'invoiceDateFrom' => date('Y-m-d', strtotime('-1 year')),
            'invoiceDateTo' => date('Y-m-d'),
        ]);

        if (!$list instanceof ListResponse || $list->values === null || $list->values->count() === 0) {
            $this->markTestSkipped('No invoices in the last year to assert on');
        }

        $firstId = $list->values->first()->id;
        $invoice = $sdk->invoices()->find($firstId);

        $this->assertInstanceOf(Invoice::class, $invoice);
        $this->assertSame($firstId, $invoice->id);
    }
}
