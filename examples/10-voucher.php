<?php

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;
use Tripletex\Model\Account;
use Tripletex\Model\Posting;
use Tripletex\Model\VatType;
use Tripletex\Model\Voucher;
use Tripletex\Plugins\UserAgentPlugin;
use Tripletex\TripletexSDK;

require '00-setup.php';

$cacheLifeTime = 3600;

$cache = new Psr16Cache(new FilesystemAdapter(
    namespace: 'tripletex',
    defaultLifetime: $cacheLifeTime,
    directory: CACHE_DIR
));

$sdk = new TripletexSDK(
    baseUrl: URL,
    consumerToken: CONSUMER_TOKEN,
    employeeToken: EMPLOYEE_TOKEN,
    cache: $cache,
    cacheLifeTime: $cacheLifeTime,
    plugins: [new UserAgentPlugin('jbevanac/tripletex')],
);

// Postings reference accounts and vat types by id, so look them up by number first
$bank = new Account(id: $sdk->ledgerAccounts()->findByNumber(1920)->id);
$sales = new Account(id: $sdk->ledgerAccounts()->findByNumber(3000)->id);
$outputVat = new VatType(id: $sdk->vatTypes()->findByNumber('3')->id);

// 1 250 kr in, 1 000 kr of it sales; Tripletex posts the 250 kr VAT itself
$voucher = new Voucher(
    date: '2026-10-31',
    description: 'Example sale',
    externalVoucherNumber: 'example-1',
    postings: [
        new Posting(row: 1, date: '2026-10-31', account: $bank, amountGross: 1250, amountGrossCurrency: 1250),
        new Posting(row: 2, date: '2026-10-31', account: $sales, vatType: $outputVat, amountGross: -1250, amountGrossCurrency: -1250),
    ],
);

// Saved as a draft, to review in Tripletex before booking
$created = $sdk->vouchers()->create($voucher, sendToLedger: false);
dd($created);

// Attach the documentation
// $attached = $sdk->vouchers()->uploadAttachment($created->id, 'example.pdf', file_get_contents('example.pdf'));
// dd($attached);

// Already booked?
// $existing = $sdk->vouchers()->findByExternalVoucherNumber('example-1', new DateTimeImmutable('2026-10-01'), new DateTimeImmutable('2026-11-01'));
// dd($existing);
