<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    public function create($payload){
        return Order::create($payload);
    }

    public function findById($code){
        return Order::with('products', 'province', 'district', 'ward')->where('code', $code)->get()->first();
    }
}
