<?php

namespace Tripletex\Tests\Unit\Model;

use Tripletex\Model\Account;
use Tripletex\Model\Posting;
use Tripletex\Model\VatType;
use Tripletex\Model\Voucher;
use Tripletex\Tests\TestCase;
use Tripletex\TripletexSDK;

class VoucherTest extends TestCase
{
    public function test_postings_serialize_account_and_vat_type_as_references(): void
    {
        $voucher = new Voucher(
            date: '2026-10-31',
            description: 'Stripe sales October 2026',
            externalVoucherNumber: 'stripe-2026-10',
            postings: [
                new Posting(row: 1, date: '2026-10-31', account: new Account(id: 11), amountGross: 1250.0, amountGrossCurrency: 1250.0),
                new Posting(row: 2, date: '2026-10-31', account: new Account(id: 22), vatType: new VatType(id: 3), amountGross: -1250.0, amountGrossCurrency: -1250.0),
            ],
        );

        $json = json_decode($voucher->toJson(), true);

        $this->assertSame([
            'date' => '2026-10-31',
            'description' => 'Stripe sales October 2026',
            'externalVoucherNumber' => 'stripe-2026-10',
            'postings' => [
                ['row' => 1, 'date' => '2026-10-31', 'account' => ['id' => 11], 'amountGross' => 1250.0, 'amountGrossCurrency' => 1250.0],
                ['row' => 2, 'date' => '2026-10-31', 'account' => ['id' => 22], 'vatType' => ['id' => 3], 'amountGross' => -1250.0, 'amountGrossCurrency' => -1250.0],
            ],
        ], $json);
    }

    public function test_make_maps_a_created_voucher(): void
    {
        $voucher = Voucher::make([
            'id' => 501,
            'number' => 0,
            'tempNumber' => 12,
            'date' => '2026-10-31',
            'externalVoucherNumber' => 'stripe-2026-10',
            'voucherType' => 7,
        ]);

        $this->assertSame(501, $voucher->id);
        $this->assertSame(12, $voucher->tempNumber);
        $this->assertSame('stripe-2026-10', $voucher->externalVoucherNumber);
        $this->assertSame(7, $voucher->voucherType->id);
    }

    public function test_create_refuses_unbalanced_postings_before_calling_tripletex(): void
    {
        $sdk = new TripletexSDK(baseUrl: 'https://tripletex.invalid/v2', consumerToken: 'x', employeeToken: 'x');

        $this->expectException(\InvalidArgumentException::class);

        $sdk->vouchers()->create([
            'date' => '2026-10-31',
            'description' => 'Unbalanced',
            'postings' => [
                ['row' => 1, 'account' => ['id' => 11], 'amountGross' => 100.0],
                ['row' => 2, 'account' => ['id' => 22], 'amountGross' => -99.99],
            ],
        ]);
    }
}
