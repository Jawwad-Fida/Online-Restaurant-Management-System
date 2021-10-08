<?php

namespace SslCommerz;

interface SslCommerzInterface
{
    public function makePayment(array $data); //pay the amount after confirmation (store in database)

    public function orderValidate($trxID, $amount, $currency, $requestData); //validate the amount if it went through or not

    public function setParams($data);

    public function setRequiredInfo(array $data);

    public function setCustomerInfo(array $data); //for customers   

    public function setShipmentInfo(array $data); //for shipment

    public function setProductInfo(array $data); //for products

    public function setAdditionalInfo(array $data); //additional for vat, etc
 
    public function callToApi($data, $header = [], $setLocalhost = false); //calls api server (url) 
}
