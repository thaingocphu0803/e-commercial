<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function create(Request $request){
        $result = $this->cartService->create($request);
        if($result){
            $cart = Cart::instance('shopping')->content();
            $message = __('custom.addCartSuccess');
            $this->sendResponse($cart, $message);
        }
    }
}
