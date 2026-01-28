<?php

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;
use Tripletex\Plugins\UserAgentPlugin;
use Tripletex\TripletexSDK;

require '00-setup.php';

$cacheLifeTime = 3600;

// PSR-6 cache (FilesystemAdapter)
$psr6Cache = new FilesystemAdapter(
    namespace: 'tripletex',
    defaultLifetime: $cacheLifeTime,
    directory: CACHE_DIR
);

// PSR-16 wrapper
$cache = new Psr16Cache($psr6Cache);


$sdk = new TripletexSDK(
    baseUrl: URL,
    consumerToken: CONSUMER_TOKEN,
    employeeToken: EMPLOYEE_TOKEN,
    cache: $cache,
    cacheLifeTime: $cacheLifeTime,
    plugins: [new UserAgentPlugin('jbevanac/tripletex')],
);

$customerId = 12345678;

$orderData = [
    'customer' => new Tripletex\Reference($customerId),
    'orderDate' => '2025-06-03',
    'deliveryDate' => '2025-06-03',
    // 'isSubscription' => true,
    'orderLines' => [
        new \Tripletex\Model\OrderLine(description: 'Some description', count: 1, unitPriceExcludingVatCurrency: 3990),
        new \Tripletex\Model\OrderLine(description: 'Another line', count: 453, unitPriceExcludingVatCurrency: 3),
    ]
];
$order = \Tripletex\Model\Order::make($orderData);

// $order = $sdk->orders()->create($order);
$orders = $sdk->orders()->list();
$sdk->logout();
