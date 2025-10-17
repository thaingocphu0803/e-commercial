<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Services\Interfaces\CartServiceInterface;
use Gloudemans\Shoppingcart\Facades\Cart;

/**
 * Class CartService
 * @package App\Services
 */
class CartService implements CartServiceInterface
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function create($request)
    {
        try {
            $payload = $request->except('_token');
            $product = $this->productRepository->getWithVariant($payload);

            if (!$product) return false;

            $cartData['id'] = (string) $product['id'];
            $cartData['name'] = $product['name'];
            $cartData['price'] = $product['price'];
            $cartData['qty'] = $payload['quantity'];
            $cartData['weight'] = 0;
            $cartData['options'] = [
                'image' => $product['image'],
            ];

            if (!empty($product['variant_uuid'])) {
                $cartData['id'] = $product['variant_uuid'];
            }

            if (!empty($product['variant_name'])) {
                $cartData['name'] = $product['name'] . " | " . str_replace('-', ', ', $product['variant_name']);
            }

            if (!empty($product['discounted_price'])) {
                $cartData['price'] = $product['discounted_price'];
                $cartData['options']['old_price'] =  $product['price'];
                $cartData['options']['discount'] =  $product['price'] - $product['discounted_price'];
            }

            Cart::instance('shopping')->add([$cartData]);

            return true;

        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function update($request)
    {
        try{
        $payload = $request->except('_token');
        $newCartItem = Cart::instance('shopping')->update($payload['rowId'], ['qty' => $payload['qty']]);
        
        $cart = Cart::instance('shopping')->content();
        $totalDiscount = caculate_cart_total($cart, 'discount');
        $totalGrand =  caculate_cart_total($cart, 'grand');

        $updateResult = [
            'newCartItem' => $newCartItem->toArray(),
            'totalDiscount' => $totalDiscount,
            'totalGrand' => $totalGrand
        ];

        return $updateResult;

        }catch(\Exception $e){
            return false;
        }

    }
}
