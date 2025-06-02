<?php

use Tripletex\TripletexSDK;

require '00-setup.php';

$sdk = new TripletexSDK(
    baseUrl: URL,
    consumerToken: CONSUMER_TOKEN,
    employeeToken: EMPLOYEE_TOKEN,
);


$invoices = $sdk->invoices()->list();
$sdk->logout();
