<?php

namespace App\Http\ViewComposers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\View\View;

class CartComposer
{
    /**
     * Create a new class instance.
     */

    public function __construct()
    {
    }

    public function compose(View $view){
        $cart  = Cart::instance('shopping')->content();
        $totalQty = caculate_cart_total($cart, 'qty');
        $view->with(compact('totalQty'));
    }
}
