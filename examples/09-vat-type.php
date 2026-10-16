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

// Find by vat number
$vatType = $sdk->vatTypes()->findByNumber('52');
dd($vatType);

// List
// $list = $sdk->vatTypes()->list();
// dd($list);

// Find
// $vatType = $sdk->vatTypes()->find(52);
// dd($vatType);
