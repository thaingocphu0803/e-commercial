<?php

namespace App\Classes;

class Momo
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function payment($order)
    {
        

        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

        $momoConfig = momo_config();

        $partnerCode = $momoConfig['partnerCode'];
        $accessKey = $momoConfig['accessKey'];
        $secretKey = $momoConfig['secretKey'];
        $amount = (String) $order->cart['totalGrand'];
        $redirectUrl = write_url('return/momo');
        $ipnUrl = write_url(canonical: 'return/ipn');
        $bankCode = "SML";

        $orderid = $order->code;
        $orderInfo = __('custom.PurchaseOrder') . ' #' . $order->code. ' ' .__('custom.payByMomo');
        $bankCode = '';
        $requestId = time() . "";
        $requestType = "payWithATM";
        $extraData = "";

        //before sign HMAC SHA256 signature
        $rawHash = "accessKey=" . $accessKey 
                    . "&amount=" . $amount 
                    . "&extraData=" . $extraData 
                    . "&ipnUrl=" . $ipnUrl 
                    . "&orderId=" . $orderid 
                    . "&orderInfo=" . $orderInfo 
                    . "&partnerCode=" . $partnerCode 
                    . "&redirectUrl=" . $redirectUrl 
                    . "&requestId=" . $requestId 
                    . "&requestType=" . $requestType;

        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data =  array(
            'partnerCode' => $partnerCode,
            'accessKey' => $accessKey,
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderid,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'bankCode' => $bankCode,
            'ipnUrl' => $ipnUrl,
            'lang' => app()->getLocale(),
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );
        $result = execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);  // decode json

        return $jsonResult;
    }
}
