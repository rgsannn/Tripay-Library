<?php

/********************************************************************************************* 
 * @script          Tripay Library
 * @description     PHP Library To Interact With All APIs From https://tripay.co.id/
 * @version         1.0.0
 * @release         November 04 2022
 * @update          ---
 * @author          Rifqi Galih Nur Ikhsan (RGSannn)
 * @email           rgsanstuy@gmail.com
 * @instagram       rgsannn
 * 
 * @copyright       Copyright © 2022, Rifqi Galih Nur Ikhsan. All Rights Reserved.
 * 
 *********************************************************************************************/

class Tripay {
    private $PrivateKey;
	private $ApiKey;
    private $MerchantCode;
    private $EndPoint = 'https://tripay.co.id/api/';

    public function __construct($Data) {
        $this->ApiKey           = $Data['ApiKey'];
        $this->PrivateKey       = $Data['PrivateKey'];
        $this->MerchantCode     = $Data['MerchantCode'];
        if($Data['Status'] == 'Development') $this->EndPoint = 'https://tripay.co.id/api-sandbox/';
    }

    public function PaymentInstructions($Payload) {
        return $this->_curl('payment/instruction?'.http_build_query($Payload), 'GET');
    }

    public function PaymentChannel($Payload = []) {
        return $this->_curl('merchant/payment-channel?'.http_build_query($Payload), 'GET');
    }

    public function FeeCalculator($Payload) {
        return $this->_curl('merchant/fee-calculator?'.http_build_query($Payload), 'GET');
    }

    public function ListTransactions($Payload) {
        return $this->_curl('merchant/transactions?'.http_build_query($Payload), 'GET');
    }

    public function ReqTransactions($Payload) {
        $Payload['expired_time']    = (time() + (24 * 60 * 60));
        $Payload['signature']       = hash_hmac('sha256', $this->MerchantCode.$Payload['merchant_ref'].$Payload['amount'], $this->PrivateKey);
        return $this->_curl('transaction/create', 'POST', http_build_query($Payload));
    }

    public function DetailTransactions($Reference) {
        return $this->_curl('transaction/detail?'.http_build_query(['reference' => $Reference]), 'GET');
    }

    // END POINT CONNECTION

    private function _curl($end_point, $method = 'GET', $postdata = null) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->EndPoint.$end_point);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer {$this->ApiKey}"]);
        if (strtolower($method) == 'post') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        } else if (strtolower($method) == 'delete') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        } else if (strtolower($method) == 'put') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        }
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $chresult = curl_exec($ch);
        curl_close($ch);
        return json_decode($chresult, true);
    }
}