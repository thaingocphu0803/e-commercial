<?php

namespace App\Http\Middleware;

use Closure;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CartMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $cart = Cart::instance('shopping')->content();
        if($cart->isEmpty()){
            if($request->routeIs('cart.index')){
                return redirect()->route('home.index')->with('warning', __('custom.cartEmpty'));
            }else{
                return back()->with('warning', __('custom.cartEmpty'));
            }
        }
        return $next($request);
    }
}
