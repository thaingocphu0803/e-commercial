<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartRequest;
use App\Mail\OrderMail;
use App\Repositories\ProvinceRepository;
use App\Services\CartService;
use App\Services\OrderService;
use App\Services\SystemService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{
    private $provinceRepository;
    private $cartService;
    private $orderService;
    private $systemService;

    public function __construct(
        ProvinceRepository $provinceRepository,
        CartService $cartService,
        OrderService $orderService,
        SystemService $systemService
    ) {
        $this->provinceRepository = $provinceRepository;
        $this->cartService = $cartService;
        $this->orderService = $orderService;
        $this->systemService = $systemService;
    }

    public function index()
    {
        $cart = Cart::instance('shopping')->content();
        $provinces = $this->provinceRepository->getAll();
        $cartTotal = caculate_cart_total($cart, 'grand', true);
        $objectCartDiscount = $this->cartService->getDiscountByCartTotal($cartTotal);
        $discountCartTotal =  $objectCartDiscount['discount'];

        return view('Frontend.cart.index', compact('cart', 'provinces', 'discountCartTotal'));
    }

    public function store(StoreCartRequest $request)
    {
        $order = $this->cartService->order($request);
        if ($order) {
            $this->mail($order->code);

            return redirect()->route('cart.success', ['code' => $order->code])->with('success', __('alert.addSuccess', ['attribute' => __('custom.PurchaseOrder')]));
        }

        return redirect()->route('cart.index')->with('error', __('alert.addError', ['attribute' => __('custom.PurchaseOrder')]));
    }

    public function success($code)
    {
        $order = $this->orderService->findById($code);

        return view('Frontend.cart.success', compact('order'));
    }

    private function mail($code)
    {
        $order = $this->orderService->findById($code);

        $system = $this->systemService->all();

        $param = [
            'to' => $order['customer_email'],
            'cc' => $system['contact_email'],
            'data' => $order
        ];

        try{
            Mail::to($param['to'])->cc($param['cc'])->send(new OrderMail($param['data']));
        }catch(\Exception $e){
            echo $e->getMessage();
        }
    }
}
