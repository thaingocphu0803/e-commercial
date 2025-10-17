<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\ProvinceRepository;
use App\Services\CartService;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{   private $provinceRepository;
    private $cartService;
    public function __construct(
        ProvinceRepository $provinceRepository,
        CartService $cartService
    ){
        $this->provinceRepository = $provinceRepository;
        $this->cartService = $cartService;
    }

    public function index(){
        $cart = Cart::instance('shopping')->content();
        $provinces = $this->provinceRepository->getAll();
        $cartTotal = caculate_cart_total($cart, 'grand', true);
        $discountCartTotal = $this->cartService->getDiscountByCartTotal($cartTotal);
        return view('Frontend.cart.index', compact('cart', 'provinces', 'discountCartTotal'));
    }
}
