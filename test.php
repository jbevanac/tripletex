<?php

global $consumerToken, $employeeToken, $url;

require __DIR__.'/vendor/autoload.php';

if (file_exists(__DIR__.'/config.php')) {
    require __DIR__.'/config.php';
} else {
    require __DIR__.'/config.sample.php';
}

$sdk = new \Tripletex\SDK(
    url: $url,
    consumerToken: $consumerToken,
    employeeToken: $employeeToken,
);

$customer = [
    'name' => 'Hello',
    'email' => 'test@example.com',
];
$customer = \Tripletex\DTO\Customer::make($customer);
$customer = $sdk->customers()->create($customer);

var_dump($customer);
$sdk->logout();
