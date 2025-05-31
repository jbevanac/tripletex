<?php

require '00-setup.php';

$sdk = new \Tripletex\SDK(
    url: URL,
    consumerToken: CONSUMER_TOKEN,
    employeeToken: EMPLOYEE_TOKEN,
);

$customerData = [
    'name' => 'Connection4',
    'email' => 'connection@example.com',
    // 'invoiceSendMethod' => 'VIPPS',
];
$customer = \Tripletex\DTO\Customer::make($customerData);

$customer = $sdk->customers()->create($customer);
$customerCreated = $customer instanceof  \Tripletex\DTO\Customer;
var_dump($customer);
var_dump($customerCreated);
$sdk->logout();
