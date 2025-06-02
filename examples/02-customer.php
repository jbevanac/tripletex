<?php

use Tripletex\TripletexSDK;

require '00-setup.php';

$sdk = new TripletexSDK(
    url: URL,
    consumerToken: CONSUMER_TOKEN,
    employeeToken: EMPLOYEE_TOKEN,
);

// List
$list = $sdk->customers()->list();
var_dump($list);

// Create
$customerData = [
    'name' => 'Connection4',
    'email' => 'connection@example.com',
    // 'invoiceSendMethod' => 'VIPPS',
];
$customer = $sdk->customers()->create($customerData);

$customerCreated = $customer instanceof  \Tripletex\DTO\Customer;
var_dump($customer);
var_dump($customerCreated);


$sdk->logout();
