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

// Find by ISO code
$country = $sdk->countries()->findByIsoCode('SE');
dd($country);

// Print enum cases for Tripletex\Helpers\Country
// foreach (['NO' => 'NORWAY', 'SE' => 'SWEDEN', 'DK' => 'DENMARK', 'FI' => 'FINLAND'] as $isoCode => $case) {
//     $country = $sdk->countries()->findByIsoCode($isoCode);
//     echo sprintf("    case %s = %d;\n", $case, $country->id);
// }

// List
// $list = $sdk->countries()->list();
// dd($list);

// Find
// $country = $sdk->countries()->find(161);
// dd($country);
