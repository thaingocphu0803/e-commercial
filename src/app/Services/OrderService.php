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
        $orderData['delivery'] = $order->delivery;
        $orderData['confirm'] = $order->confirm;
        $orderData['created_at'] = $order->created_at->format('Y/m/d H:i:s');
        $orderData['customer_phone'] = $order->phone;
        $orderData['customer_name'] = $order->fullname;
        $orderData['customer_email'] = $order->email;
        $orderData['customer_address'] = $order->address;
        $orderData['customer_province']= $order->province->name ?? __('custom.none');
        $orderData['customer_district']= $order->district->name ?? __('custom.none');
        $orderData['customer_ward']= $order->ward->name ?? __('custom.none');
        $orderData['customer_province_id']= $order->province_id;
        $orderData['customer_district_id']= $order->district_id;
        $orderData['customer_ward_id']= $order->ward_id;
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
        $target =  $request->input('target');
        switch($target){
            case "orderNote":
                return $this->updateOrderDescription($request);
                break;
            case "customerInfor":
                return $this->updateOrderCustomerInfor($request);
                break;
            case "orderConfirm":
                return $this->updateOrderConfirm($request);
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

    private function updateOrderDescription($request){
        try{
            DB::beginTransaction();

            $code = (int) $request->input('code');
            $payload = $request->except('code', 'target', '_token');

            $this->orderRepository->update($code, $payload);

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollBack();
            return false;
        }
    }

    private function updateOrderCustomerInfor($request){
        try{
            DB::beginTransaction();

            $code = $request->input('code');
            $payload = $request->except('code', 'target', '_token');

            $this->orderRepository->update($code, $payload);
            DB::commit();
            return true;
        }catch(\Exception $e){
            DB::rollBack();
            return false;
        }
    }

    private function updateOrderConfirm($request){
        try{
            DB::beginTransaction();

            $code = $request->input('code');
            $payload = $request->except('code', 'target', '_token');

            $this->orderRepository->update($code, $payload);
            DB::commit();
            return true;
        }catch(\Exception $e){
            DB::rollBack();
            return false;
        }
    }
}
