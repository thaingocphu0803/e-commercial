<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use App\Services\Interfaces\OrderServiceInterface;
use Illuminate\Support\Facades\DB;

/**
 * Class OrderService
 * @package App\Services
 */
class OrderService implements OrderServiceInterface
{
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function paginate($request)
    {
        $orders = $this->orderRepository->paginate($request);
        return $orders;
    }

    public function findById($code)
    {
        $order =  $this->orderRepository->findById($code);

        $orderData['code'] = $order->code;
        $orderData['note'] = $order->description;
        $orderData['created_at'] = $order->created_at->format('Y/m/d H:i:s');
        $orderData['customer_phone'] = $order->phone;
        $orderData['customer_name'] = $order->fullname;
        $orderData['customer_email'] = $order->email;
        $orderData['customer_address'] = format_address($order);
        $orderData['customer_method'] = $order->method;
        $orderData['shipping_fee'] = $order->shipping_fee;
        $orderData['total_price_original'] = $this->caculatePriceOriginal($order->products);
        $orderData['total_discount'] = $this->caculateOrderDiscount($order);
        $orderData['total_grand'] = $order->cart['totalGrand'];
        $orderData['cart_discount_code'] = $order->promotion['code'];
        $orderData['products'] = $this->getOrderProduct($order->products);

        return $orderData;
    }

    public function ajaxUpdate($request)
    {
        $payload = $request->except('_token');
        switch($payload['target']){
            case "orderNote":
                return $this->updateOrderDescription($payload);
                break;
            case "customerInfor":
                break;
            default:
                break;
        }
    }

    private function caculateOrderDiscount($order){
        $product_discount = floatval($order->cart['totalDiscount']);
        $cart_discount = floatval($order->promotion['discount']);

        return $product_discount + $cart_discount;
    }

    private function getOrderProduct($products){
        $temps = [];

        foreach($products->pluck('pivot') as $product){
            // dd($product->option);
            $temps[] = [
                'image' => $this->getProductOptionItem( $product->option, 'image'),
                'name' => $product->name,
                'qty' => $product->qty,
                'price' => $product->price,
                'price_original' => $product->price_original
            ];
        }

        return $temps;
    }

    private function caculatePriceOriginal($products){
        $price_originals = $products->pluck('pivot.price_original');
        return $price_originals->sum();
    }

    // handle get product option
    private function getProductOptionItem($option, $columnName) {
        $decodeOption = json_decode($option, true);

        return $decodeOption[$columnName];
    }

    private function updateOrderDescription($payload){
        try{
            DB::beginTransaction();

            $code = $payload['code'];
            $updatePayload = [
                'description' => $payload['descripion']
            ];
            $this->orderRepository->update($code, $updatePayload);

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollBack();
            return false;
        }
    }
}
