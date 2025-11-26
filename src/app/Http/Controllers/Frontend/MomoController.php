<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\Request;

class MomoController extends Controller
{
    private $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }


    public function return_momo(Request $request)
    {
        $momoConfig = momo_config();
        $secretKey = $momoConfig['secretKey'];

        if ($request->input()) {
            $partnerCode = $request->input('partnerCode');
            $accessKey = $momoConfig['accessKey'];
            $orderId = $request->input('orderId');
            $message = $request->input('message');
            $transId = $request->input('transId');
            $orderInfo = $request->input('orderInfo');
            $amount = $request->input('amount');
            $resultCode = $request->input('resultCode');
            $responseTime = $request->input('responseTime');
            $requestId = $request->input('requestId');
            $extraData = $request->input('extraData');
            $payType =  $request->input('payType');
            $orderType = $request->input('orderType');
            $m2signature = $request->input('signature');


            //Checksum
            $rawHash =  "accessKey=" . $accessKey
                . "&amount=" . $amount
                . "&extraData=" . $extraData
                . "&message=" . $message
                . "&orderId=" . $orderId
                . "&orderInfo=" . $orderInfo
                . "&orderType=" . $orderType
                . "&partnerCode=" . $partnerCode
                . "&payType=" . $payType
                . "&requestId=" . $requestId
                . "&responseTime=" . $responseTime
                . "&resultCode=" . $resultCode
                . "&transId=" . $transId;

            $partnerSignature = hash_hmac("sha256", $rawHash, $secretKey);

            if ($partnerSignature == $m2signature) {
                $code = $orderId;
                $payload = [
                    'confirm' => 'confirm',
                    'payment' => 'paid'
                ];
                $this->orderService->update($code, $payload);
            }

            $order = $this->orderService->findById($orderId);
            $momo = [
                'resultCode' => $resultCode,
                'm2signature' => $m2signature,
                'partnerSignature' => $partnerSignature
            ];
            $template = 'components.frontend.cart.momo';
            return view('Frontend.cart.success', compact('order', 'momo', 'template'));
        } else {
            abort(404);
        }
    }

    public function return_ipn(Request $request)
    {
        $momoConfig = momo_config();
        $secretKey = $momoConfig['secretKey'];

        if ($request->input()) {
            $partnerCode = $request->input('partnerCode');
            $accessKey = $momoConfig['accessKey'];
            $orderId = $request->input('orderId');
            $message = $request->input('message');
            $transId = $request->input('transId');
            $orderInfo = $request->input('orderInfo');
            $amount = $request->input('amount');
            $resultCode = $request->input('resultCode');
            $responseTime = $request->input('responseTime');
            $requestId = $request->input('requestId');
            $extraData = $request->input('extraData');
            $payType =  $request->input('payType');
            $orderType = $request->input('orderType');
            $m2signature = $request->input('signature');


            //Checksum
            $rawHash =  "accessKey=" . $accessKey
                . "&amount=" . $amount
                . "&extraData=" . $extraData
                . "&message=" . $message
                . "&orderId=" . $orderId
                . "&orderInfo=" . $orderInfo
                . "&orderType=" . $orderType
                . "&partnerCode=" . $partnerCode
                . "&payType=" . $payType
                . "&requestId=" . $requestId
                . "&responseTime=" . $responseTime
                . "&resultCode=" . $resultCode
                . "&transId=" . $transId;

            $partnerSignature = hash_hmac("sha256", $rawHash, $secretKey);

            if ($partnerSignature == $m2signature) {
                echo 'ok';
            } else {
                echo 'ng';
            }

            $debugger = array();
            $debugger['rawData'] = $rawHash;
            $debugger['momoSignature'] = $m2signature;
            $debugger['partnerSignature'] = $partnerSignature;

            if($m2signature == $partnerSignature) {
                $response['message'] = "Received payment result success";
            } else {
                $response['message'] = "ERROR! Fail checksum";
            }
            $response['debugger'] = $debugger;
            echo json_encode($response);
        }
    }
}
