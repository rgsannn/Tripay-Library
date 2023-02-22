<?php
header('Content-Type: application/json');
require 'Tripay.php';

$Tripay = new Tripay([
    'ApiKey' => '', // YOUR API KEY
    'PrivateKey' => '', // YOUR PRIVATE KEY
    'MerchantCode' => '', // YOUR MERCHANT CODE
    'Status' => 'Development' // Development Or Production
]);

print_r(json_encode($Tripay->PaymentChannel(['code' => 'BRIVA']), JSON_PRETTY_PRINT));
