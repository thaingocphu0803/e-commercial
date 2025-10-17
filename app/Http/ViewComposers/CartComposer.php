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
        $totalQty = $cart->count();

        $view->with(compact('totalQty'));
    }
}
