<?php

/********************************************************************************************* 
 * @script          Tripay Library
 * @description     PHP Library To Interact With All APIs From https://tripay.co.id/
 * @version         1.0.0
 * @release         November 04 2022
 * @update          February 22 2023
 * @author          Rifqi Galih Nur Ikhsan (RGSannn)
 * @email           rgsanstuy@gmail.com
 * @instagram       rgsannn
 * 
 * @copyright       Copyright © 2022, Rifqi Galih Nur Ikhsan. All Rights Reserved.
 * 
 *********************************************************************************************/

 class TripayConnection {
    const ENDPOINT_PRODUCTION = 'https://tripay.co.id/api/';
    const ENDPOINT_SANDBOX = 'https://tripay.co.id/api-sandbox/';

    const REQUEST_GET = 'GET';
    const REQUEST_POST = 'POST';
    const REQUEST_PUT = 'PUT';
    const REQUEST_DELETE = 'DELETE';

    private $apiKey;
    private $privateKey;
    private $merchantCode;
    private $endpoint;

    public function __construct($apiKey, $privateKey, $merchantCode, $status = 'Development') {
        $this->apiKey = $apiKey;
        $this->privateKey = $privateKey;
        $this->merchantCode = $merchantCode;
        $this->endpoint = ($status == 'Development') ? self::ENDPOINT_SANDBOX : self::ENDPOINT_PRODUCTION;
    }

    public function call($endpoint, $method, $postdata = null) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->endpoint . $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer {$this->apiKey}"]);

        switch ($method) {
            case self::REQUEST_POST:
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
                break;
            case self::REQUEST_PUT:
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, self::REQUEST_PUT);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
                break;
            case self::REQUEST_DELETE:
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, self::REQUEST_DELETE);
                break;
        }

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }

    public function getMerchantCode() {
        return $this->merchantCode;
    }

    public function getPrivateKey() {
        return $this->privateKey;
    }
}

class Tripay {
    private $connection;

    public function __construct($data) {
        $this->connection = new TripayConnection($data['ApiKey'], $data['PrivateKey'], $data['MerchantCode'], $data['Status']);
    }

    public function paymentInstructions($payload) {
        $endpoint = 'payment/instruction?' . http_build_query($payload);
        return $this->connection->call($endpoint, TripayConnection::REQUEST_GET);
    }

    public function paymentChannel($payload = []) {
        $endpoint = 'merchant/payment-channel?' . http_build_query($payload);
        return $this->connection->call($endpoint, TripayConnection::REQUEST_GET);
    }

    public function feeCalculator($payload) {
        $endpoint = 'merchant/fee-calculator?' . http_build_query($payload);
        return $this->connection->call($endpoint, TripayConnection::REQUEST_GET);
    }

    public function reqTransactions($payload) {
        $endpoint                   = 'transaction/create';
        $payload['expired_time']    = (time() + (24 * 60 * 60));
        $payload['signature']       = hash_hmac('sha256', $this->connection->getMerchantCode() . $payload['merchant_ref'] . $payload['amount'], $this->connection->getPrivateKey());

        return $this->connection->call($endpoint, TripayConnection::REQUEST_POST, http_build_query($payload));
    }

    public function detailTransactions($reference) {
        $endpoint = 'transaction/detail?' . http_build_query(['reference' => $reference]);
        return $this->connection->call($endpoint, TripayConnection::REQUEST_GET);
    }
      
}