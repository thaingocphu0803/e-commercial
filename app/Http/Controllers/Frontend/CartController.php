<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(){

    }

    public function index(){
       $cart = Cart::instance('shopping')->content();

       return view('Frontend.cart.index', compact('cart'));
    }
}
