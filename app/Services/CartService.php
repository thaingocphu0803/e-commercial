<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Repositories\PromotionRepository;
use App\Services\Interfaces\CartServiceInterface;
use Gloudemans\Shoppingcart\Facades\Cart;

/**
 * Class CartService
 * @package App\Services
 */
class CartService implements CartServiceInterface
{
    private $productRepository;
    private $promotionRepository;

    public function __construct(
        ProductRepository $productRepository,
        PromotionRepository $promotionRepository
    )
    {
        $this->productRepository = $productRepository;
        $this->promotionRepository = $promotionRepository;

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
        try {
            $payload = $request->except('_token');
            $newCartItem = Cart::instance('shopping')->update($payload['rowId'], ['qty' => $payload['qty']]);

            $cart = Cart::instance('shopping')->content();
            $totalDiscount = caculate_cart_total($cart, 'discount', true);
            $totalGrand =  caculate_cart_total($cart, 'grand', true);
            $totalQty = caculate_cart_total($cart, 'qty');
            $discountCartTotal = $this->getDiscountByCartTotal($totalGrand);

            $updateResult = [
                'newCartItem' => $newCartItem->toArray(),
                'totalDiscount' => $totalDiscount,
                'totalGrand' => $totalGrand,
                'totalQty' => $totalQty,
                'discountCartTotal' => $discountCartTotal
            ];

            return $updateResult;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function delete($request)
    {
        try {
            $payload = $request->except('_token');
            Cart::instance('shopping')->remove($payload['rowId']);

            $cart = Cart::instance('shopping')->content();
            $totalDiscount = caculate_cart_total($cart, 'discount', true);
            $totalGrand =  caculate_cart_total($cart, 'grand', true);
            $totalQty = caculate_cart_total($cart, 'qty');
            $discountCartTotal = $this->getDiscountByCartTotal($totalGrand);

            $updateResult = [
                'totalDiscount' => $totalDiscount,
                'totalGrand' => $totalGrand,
                'totalQty' => $totalQty,
                'discountCartTotal' => $discountCartTotal

            ];

            return $updateResult;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getDiscountByCartTotal($cartTotal){
        $promotions = $this->promotionRepository->getAllPromotionByCartTotal();
        $discount = 0;
        foreach($promotions as $promotion){
            $promotionInfor = $promotion->discount_information['infor'];
            if($promotionInfor['price_from'] && (count($promotionInfor['price_from'])) > 1){
               foreach($promotionInfor['price_from'] as $key => $val){
                $priceFrom = $this->strPriceReformat($val, 'f');
                $priceTo =  $this->strPriceReformat($promotionInfor['price_to'][$key], 'f');
                if( $cartTotal && ($cartTotal >= $priceFrom) && ($cartTotal <= $priceTo)){

                    if($promotionInfor['discount_type'][$key] == 'amount'){
                        $currentDiscount =   $this->strPriceReformat($promotionInfor['discount'][$key], 'f');
                        $discount = max($discount, $currentDiscount);
                    }else if($promotionInfor['discount_type'][$key] == 'percent'){
                        $currentDiscount = $cartTotal * ($this->strPriceReformat($promotionInfor['discount'][$key], 'i')/100);
                        $discount = max($discount, $currentDiscount);
                    }
                }
               }
            }else{
                $priceFrom =  $this->strPriceReformat($promotionInfor['price_from'][0], 'f');
                $priceTo =  $this->strPriceReformat($promotionInfor['price_to'][0], 'f');
                if( $cartTotal && ($cartTotal >= $priceFrom) && ($cartTotal <= $priceTo)){
                    echo 2;
                    if($promotionInfor['discount_type'][0] == 'amount'){
                        $currentDiscount =   $this->strPriceReformat($promotionInfor['discount'][0], 'f');
                        $discount = max($discount, $currentDiscount);

                    }else if($promotionInfor['discount_type'][0] == 'percent'){
                        $currentDiscount = $cartTotal * ($this->strPriceReformat($promotionInfor['discount'][0], 'i')/100);
                        $discount = max($discount, $currentDiscount);
                    }
                }
            }
        }

        return $discount;
    }
    // format string price to int price or float pricer
    private function strPriceReformat($price, $type){
        $newStrPrice = str_replace(',', '', $price);
        $convertedPrice = 0;
        if($type == 'f'){
            $convertedPrice = floatval($newStrPrice);
        }else if($type == 'i'){
            $convertedPrice = intval($newStrPrice);
        }

        return $convertedPrice;
    }
}



