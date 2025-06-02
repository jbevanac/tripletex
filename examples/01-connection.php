<?php

use Tripletex\TripletexSDK;

require '00-setup.php';

try {
    $sdk = new TripletexSDK(
        baseUrl: URL,
        consumerToken: CONSUMER_TOKEN,
        employeeToken: EMPLOYEE_TOKEN,
    );
    $sdk->logout();
    var_dump('Connected successfully');
} catch (Exception $e) {
    var_dump('Failed');
    throw $e;
}
