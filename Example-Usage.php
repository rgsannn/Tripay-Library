<?php
header('Content-Type: application/json');
require 'Tripay.php';
$Tripay = new Tripay([
    'ApiKey' => 'YOUR API KEY',
    'PrivateKey' => 'YOUR PRIVATE KEY',
    'MerchantCode' => 'YOUR MERCHANT CODE',
    'Status' => 'Development',
    'SandBox' => [
        'ApiKey' => 'YOUR SANDBOX API KEY',
        'PrivateKey' => 'YOUR SANDBOX PRIVATE KEY',
        'MerchantCode' => 'YOUR SANDBOX MERCHANT CODE',
    ]
]);

print_r(json_encode($Tripay->PaymentChannel(['code' => 'BRIVA']), JSON_PRETTY_PRINT));
