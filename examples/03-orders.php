<?php

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;
use Tripletex\Model\OrderLine;
use Tripletex\Plugins\UserAgentPlugin;
use Tripletex\Reference;
use Tripletex\TripletexSDK;

require '00-setup.php';

$cacheLifeTime = 3600;

$psr6Cache = new FilesystemAdapter(
    namespace: 'tripletex',
    defaultLifetime: $cacheLifeTime,
    directory: CACHE_DIR
);

$cache = new Psr16Cache($psr6Cache);

$sdk = new TripletexSDK(
    baseUrl: URL,
    consumerToken: CONSUMER_TOKEN,
    employeeToken: EMPLOYEE_TOKEN,
    cache: $cache,
    cacheLifeTime: $cacheLifeTime,
    plugins: [new UserAgentPlugin('jbevanac/tripletex')],
);

// List
$orders = $sdk->orders()->list();
dd($orders);

// Create
// $customerId = 12345678;
// $order = $sdk->orders()->create([
//     'customer' => new Reference($customerId),
//     'orderDate' => date('Y-m-d'),
//     'deliveryDate' => date('Y-m-d'),
//     'orderLines' => [
//         new OrderLine(description: 'Consulting', count: 1, unitPriceExcludingVatCurrency: 3990),
//         new OrderLine(description: 'Support', count: 5, unitPriceExcludingVatCurrency: 800),
//     ],
// ]);
// dd($order);

// Update
// $sdk->orders()->update($order->id, ['invoiceComment' => 'Updated comment']);
