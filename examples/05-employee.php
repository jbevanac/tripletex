<?php

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;
use Tripletex\Plugins\UserAgentPlugin;
use Tripletex\Query\Filters\FieldsFilter;
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

// List (with optional field selection)
$listResponse = $sdk->employee()->list([
    new FieldsFilter(['id', 'firstName', 'lastName', 'employeeNumber']),
]);
dd($listResponse);

// Find
// $employee = $sdk->employee()->find(12345678);
// dd($employee);

// Update
// $sdk->employee()->update(12345678, [
//     'email' => 'new.email@example.com',
//     'phoneNumberMobile' => '+4791234567',
// ]);
