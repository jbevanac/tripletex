<?php

require '00-setup.php';

$sdk = new \Tripletex\TripletexSDK(
    url: URL,
    consumerToken: CONSUMER_TOKEN,
    employeeToken: EMPLOYEE_TOKEN,
);

$customerId = 80374017;

$orderData = [
    'customer' => new Tripletex\Reference($customerId),
    'orderDate' => '2025-06-02',
    'deliveryDate' => '2025-06-02',
];
$order = \Tripletex\DTO\Order::make($orderData);


$order = $sdk->orders()->create($order);

$sdk->logout();
var_dump($order);
