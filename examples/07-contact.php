<?php

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;
use Tripletex\Plugins\UserAgentPlugin;
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
$list = $sdk->contacts()->list();
dd($list);

// Create
// $contact = $sdk->contacts()->create([
//     'firstName' => 'Jane',
//     'lastName' => 'Doe',
//     'email' => 'jane.doe@example.com',
//     'phoneNumberMobile' => '+4791234567',
//     'customer' => 12345678,
// ]);
// dd($contact);

// Find
// $contact = $sdk->contacts()->find(12345678);
// dd($contact);

// Update
// $sdk->contacts()->update(12345678, [
//     'email' => 'updated@example.com',
//     'isInactive' => false,
// ]);
