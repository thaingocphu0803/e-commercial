<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Repositories\PromotionRepository;
use App\Repositories\SystemRepository;
use App\Services\Interfaces\CartServiceInterface;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;


/**
 * Class CartService
 * @package App\Services
 */
class CartService implements CartServiceInterface
{
    private $productRepository;
    private $promotionRepository;
    private $orderRepository;
    private $systemRepository;

    public function __construct(
        ProductRepository $productRepository,
        PromotionRepository $promotionRepository,
        OrderRepository $orderRepository,
        SystemRepository $systemRepository
    ) {
        $this->productRepository = $productRepository;
        $this->promotionRepository = $promotionRepository;
        $this->orderRepository = $orderRepository;
        $this->systemRepository = $systemRepository;
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
                $cartData['id'] = (string) $product['id'] . ":" . $product['variant_uuid'];
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

    public function order($request)
    {
        try {
            DB::beginTransaction();
            $orderPayload = $this->getOrderPayload($request);
            $order = $this->orderRepository->create($orderPayload);
            if ($order->id > 0) {
                $this->createOrderProduct($orderPayload, $order);
                $this->createOrderPayment($request->input('method'));
                Cart::instance('shopping')->destroy();
            }

            DB::commit();

            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
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
            $objectCartDiscount = $this->getDiscountByCartTotal($totalGrand);
            $discountCartTotal =  $objectCartDiscount['discount'];

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
            $objectCartDiscount = $this->getDiscountByCartTotal($totalGrand);
            $discountCartTotal =  $objectCartDiscount['discount'];

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

    public function getDiscountByCartTotal($cartTotal)
    {
        $promotions = $this->promotionRepository->getAllPromotionByCartTotal();

        $discount = 0;
        $code = null;
        $name = null;
        $startDate = null;
        $endDate = null;

        foreach ($promotions as $promotion) {
            $promotionInfor = $promotion->discount_information['infor'];
            if ($promotionInfor['price_from'] && (count($promotionInfor['price_from'])) > 1) {
                foreach ($promotionInfor['price_from'] as $key => $val) {
                    $priceFrom = $this->strPriceReformat($val, 'f');
                    $priceTo =  $this->strPriceReformat($promotionInfor['price_to'][$key], 'f');
                    if ($cartTotal && ($cartTotal >= $priceFrom) && ($cartTotal <= $priceTo)) {
                        $name = $promotion->name;
                        $code = $promotion->code;
                        $startDate = $promotion->start_date;
                        $endDate = $promotion->end_date;

                        if ($promotionInfor['discount_type'][$key] == 'amount') {
                            $currentDiscount =   $this->strPriceReformat($promotionInfor['discount'][$key], 'f');
                            $discount = max($discount, $currentDiscount);
                        } else if ($promotionInfor['discount_type'][$key] == 'percent') {
                            $currentDiscount = $cartTotal * ($this->strPriceReformat($promotionInfor['discount'][$key], 'i') / 100);
                            $discount = max($discount, $currentDiscount);
                        }
                    }
                }
            } else {
                $priceFrom =  $this->strPriceReformat($promotionInfor['price_from'][0], 'f');
                $priceTo =  $this->strPriceReformat($promotionInfor['price_to'][0], 'f');
                if ($cartTotal && ($cartTotal >= $priceFrom) && ($cartTotal <= $priceTo)) {
                    $name = $promotion->name;
                    $code = $promotion->code;
                    $startDate = $promotion->start_date;
                    $endDate = $promotion->end_date;

                    if ($promotionInfor['discount_type'][0] == 'amount') {
                        $currentDiscount =   $this->strPriceReformat($promotionInfor['discount'][0], 'f');
                        $discount = max($discount, $currentDiscount);
                    } else if ($promotionInfor['discount_type'][0] == 'percent') {
                        $currentDiscount = $cartTotal * ($this->strPriceReformat($promotionInfor['discount'][0], 'i') / 100);
                        $discount = max($discount, $currentDiscount);
                    }
                }
            }
        }

        return [
            'name' => $name,
            'code' => $code,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'discount' => $discount,
        ];
    }
    // format string price to int price or float pricer
    private function strPriceReformat($price, $type)
    {
        $newStrPrice = str_replace(',', '', $price);
        $convertedPrice = 0;
        if ($type == 'f') {
            $convertedPrice = floatval($newStrPrice);
        } else if ($type == 'i') {
            $convertedPrice = intval($newStrPrice);
        }

        return $convertedPrice;
    }

    // handle to get order payload
    private function getOrderPayload($request)
    {
        $cart = Cart::instance('shopping')->content();
        $totalGrand =  caculate_cart_total($cart, 'grand', true);
        $totalQty = caculate_cart_total($cart, 'qty');
        $totalDiscount = caculate_cart_total($cart, 'discount', true);
        $objectCartDiscount = $this->getDiscountByCartTotal($totalGrand);
        $payload = $request->except('_token');
        $payload['code'] = time();
        $payload['cart'] = [
            'totalQty' =>  $totalQty,
            'totalGrand' => $totalGrand,
            'totalDiscount' => $totalDiscount,
            'detail' => $cart->toArray()
        ];

        $payload['promotion'] = $objectCartDiscount;
        $payload['confirm'] = array_key_first(__('module.confirm_stt'));
        $payload['payment'] = array_key_first(__('module.payment_stt'));

        $payload['delivery'] = array_key_first(__('module.delivery_stt'));
        return $payload;
    }

    private function createOrderProduct($orderPayload, $order)
    {
        $temps = [];

        foreach ($orderPayload['cart']['detail'] as $item) {
            $combine_id = explode(':', $item['id']);
            $temps[] = [
                'product_id' => $combine_id[0],
                'uuid' => $combine_id[1] ?? null,
                'name' => $item['name'],
                'price' => $item['price'],
                'qty' => $item['qty'],
                'price_original' => $item['options']['old_price'] ?? $item['price'],
                'option' => json_encode($item['options'])
            ];
        }

        $order->products()->sync($temps);
    }

    private function createOrderPayment($method)
    {
        switch ($method) {
            case "zalopay":
                $this->handleZaloPay();
                break;
            case "momo":
                $this->handleMomoPay();
                break;
            case "shopee":
                $this->handleShopeePay();
                break;
            case "vnpay":
                $this->handleVnPay();
                break;
            default:
                break;
        }
    }

    private function handleZaloPay(){}
    private function handleMomoPay(){}
    private function handleShopeePay(){}
    private function handleVnPay(){}

}
