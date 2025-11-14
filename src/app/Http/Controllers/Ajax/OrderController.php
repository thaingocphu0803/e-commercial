<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $orderService;

    public function __construct(OrderService $orderService) {
        $this->orderService = $orderService;
    }

    public function ajaxUpdate(Request $request)
    {
        $result =  $this->orderService->ajaxUpdate($request);

        if($result){
            $message = __('custom.updateOrderSuccess');

            $this->sendResponse([], $message, 0, 'ok');
        }else {
            $message = __('custom.updateOrderFail');
            $this->sendResponse([], $message, 1);
        }
    }
}
