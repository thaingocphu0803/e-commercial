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
            $this->sendResponse([], '', 0, 'ok');
        }else {
            $this->sendResponse();
        }
    }
}
