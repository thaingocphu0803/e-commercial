<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Repositories\ProvinceRepository;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{   private $provinceRepository;
    public function __construct(ProvinceRepository $provinceRepository){
        $this->provinceRepository = $provinceRepository;
    }

    public function index(){
       $cart = Cart::instance('shopping')->content();
        $provinces = $this->provinceRepository->getAll();
       return view('Frontend.cart.index', compact('cart', 'provinces'));
    }
}
