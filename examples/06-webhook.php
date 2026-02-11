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
$event1 = [
    'event' => 'employee.delete',
    'targetUrl' => WEBHOOK_TARGET_URL,
    'authHeaderName' => 'tripletex-signature',
    'authHeaderValue' => 'super-secret-value',
];
$event2 = [
    'event' => 'employee.update',
    'targetUrl' => WEBHOOK_TARGET_URL,
    'authHeaderName' => 'tripletex-signature',
    'authHeaderValue' => 'super-secret-value',
];

$response = $sdk->webhook()->list();
$response = $sdk->webhook()->create($event1);
$response = $sdk->webhook()->find(123);
$response = $sdk->webhook()->delete(123);
$response = $sdk->webhook()->createList([$event1, $event2]);
$response = $sdk->webhook()->update([$event1], 123);
$response = $sdk->webhook()->updateList([$event1, $event2]);
$response = $sdk->webhook()->deleteList([123, 124]);

dd($response);
