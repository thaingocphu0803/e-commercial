<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartRequest;
use App\Mail\Order;
use App\Repositories\ProvinceRepository;
use App\Services\CartService;
use App\Services\OrderService;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{   private $provinceRepository;
    private $cartService;
    private $orderService;
    public function __construct(
        ProvinceRepository $provinceRepository,
        CartService $cartService,
        OrderService $orderService
    ){
        $this->provinceRepository = $provinceRepository;
        $this->cartService = $cartService;
        $this->orderService = $orderService;
    }

    public function index(){
        $cart = Cart::instance('shopping')->content();
        $provinces = $this->provinceRepository->getAll();
        $cartTotal = caculate_cart_total($cart, 'grand', true);
        $objectCartDiscount = $this->cartService->getDiscountByCartTotal($cartTotal);
        $discountCartTotal =  $objectCartDiscount['discount'];

        return view('Frontend.cart.index', compact('cart', 'provinces', 'discountCartTotal'));
    }

    public function store(StoreCartRequest $request){
        $order = $this->cartService->order($request);
        if($order){
            return redirect()->route('cart.success', ['code' => $order->code])->with('success', __('alert.addSuccess', ['attribute'=> __('custom.PurchaseOrder')]));
        }

        return redirect()->route('cart.index')->with('error', __('alert.addError', ['attribute'=> __('custom.PurchaseOrder')]));
    }

    public function success($code){
        $order = $this->orderService->findById($code);

        return view('Frontend.cart.success', compact('order'));
    }
}
