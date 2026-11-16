<?php

namespace Tripletex\Tests\Integration;

use Tripletex\Model\Account;
use Tripletex\Model\Posting;
use Tripletex\Model\VatType;
use Tripletex\Model\Voucher;
use Tripletex\Tests\TestCase;

class LedgerTest extends TestCase
{
    public function test_find_account_by_number(): void
    {
        $this->skipIfNoCredentials();

        $account = $this->sdkFromEnv()->ledgerAccounts()->findByNumber(3000);

        $this->assertInstanceOf(Account::class, $account);
        $this->assertSame(3000, $account->number);
    }

    public function test_find_account_by_number_returns_null_for_unknown_number(): void
    {
        $this->skipIfNoCredentials();

        $this->assertNull($this->sdkFromEnv()->ledgerAccounts()->findByNumber(99999));
    }

    public function test_create_find_and_delete_draft_voucher(): void
    {
        $this->skipIfNoCredentials();

        $sdk = $this->sdkFromEnv();
        $bank = $sdk->ledgerAccounts()->findByNumber(1920);
        $sales = $sdk->ledgerAccounts()->findByNumber(3000);
        $outputVat = $sdk->vatTypes()->findByNumber('3');

        $date = (new \DateTimeImmutable())->format('Y-m-d');
        $external = 'sdk-test-'.bin2hex(random_bytes(4));

        $created = $sdk->vouchers()->create(new Voucher(
            date: $date,
            description: 'SDK integration test',
            externalVoucherNumber: $external,
            postings: [
                new Posting(row: 1, date: $date, account: new Account(id: $bank->id), amountGross: 125.0, amountGrossCurrency: 125.0),
                new Posting(row: 2, date: $date, account: new Account(id: $sales->id), vatType: new VatType(id: $outputVat->id), amountGross: -125.0, amountGrossCurrency: -125.0),
            ],
        ), sendToLedger: false);

        $this->assertInstanceOf(Voucher::class, $created, $created->message ?? '');
        $this->assertSame($external, $created->externalVoucherNumber);

        $found = $sdk->vouchers()->findByExternalVoucherNumber(
            $external,
            new \DateTimeImmutable('today'),
            new \DateTimeImmutable('tomorrow'),
        );
        $this->assertSame($created->id, $found?->id);

        $this->assertTrue($sdk->vouchers()->delete($created->id));
    }
}
