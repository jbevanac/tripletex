<?php

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;
use Tripletex\Plugins\UserAgentPlugin;
use Tripletex\Query\Filters\FieldsFilter;
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
$list = $sdk->employee()->list([
    new FieldsFilter(['id, firstName']),
]);

if ($list->count() > 0) {
    $firstName = $list->first()->firstName;
    $lastName = $list->first()->lastName;
    dump($firstName);
    dump($lastName);

    $employee = $sdk->employee()->find($list->first()->id);
    dump($employee->id);
    dump($employee->firstName);
    dd($employee->lastName);
}
