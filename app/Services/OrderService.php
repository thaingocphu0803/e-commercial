<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use App\Services\Interfaces\OrderServiceInterface;

/**
 * Class OrderService
 * @package App\Services
 */
class OrderService implements OrderServiceInterface
{
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository){
        $this->orderRepository = $orderRepository;
    }

    public function findById($code){
        $order =  $this->orderRepository->findById($code);

        $orderData['code'] = $order->code;
        $orderData['created_at'] = $order->created_at;
        $orderData['shipping_fee'] = $order->shipping_fee;
        $orderData['customer_phone'] = $order->phone;
        $orderData['customer_name'] = $order->fullname;
        $orderData['total_grand'] = $order->cart['totalGrand'];


        dd($order, $orderData);
    }
}
