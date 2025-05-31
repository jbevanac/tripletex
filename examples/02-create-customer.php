<?php

require '00-setup.php';

$sdk = new \Tripletex\SDK(
    url: URL,
    consumerToken: CONSUMER_TOKEN,
    employeeToken: EMPLOYEE_TOKEN,
);

$customerData = [
    'name' => 'Connection2',
    'email' => 'connection@example.com',
];
$customer = \Tripletex\DTO\Customer::make($customerData);

$customer = $sdk->customers()->create($customer);
var_dump($customer);

$sdk->logout();
