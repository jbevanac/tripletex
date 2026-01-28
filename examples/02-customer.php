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

// List
$list = $sdk->customers()->list();

dd($list);

//
// // Create
// $customerData = [
//     'name' => 'Connection',
//     'email' => 'connection@example.com',
//     // 'invoiceSendMethod' => 'VIPPS',
// ];

// $customer = $sdk->customers()->create($customerData);
//
// $customerCreated = $customer instanceof  \Tripletex\Model\Customer;
// var_dump($customer);
// var_dump($customerCreated);
