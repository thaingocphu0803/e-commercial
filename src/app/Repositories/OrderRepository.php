<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    public function create($payload)
    {
        return Order::create($payload);
    }

    public function update($code, $payload)
    {
        return Order::where('code', $code)->update($payload);
    }

    public function findById($code)
    {
        return Order::with('products', 'province', 'district', 'ward')->where('code', $code)->get()->first();
    }

    public function paginate($request)
    {

        $perpage = $request->input('perpage') ?? 10;
        $keyword = $request->input('keyword') ?? null;
        $publish = $request->input('publish') ?? null;
        $fieldSearch = ['code', 'fullname', 'phone', 'address'];

        $dropdownCondition = [
            'payment' => $request->input('payment_stt'),
            'confirm' => $request->input('confirm_stt'),
            'delivery' => $request->input('delivery_stt'),
            'method' => $request->input('method')
        ];

        $dateRange =  $request->input('date_range');

        $query = Order::with(
            'province',
            'district',
            'ward',
        )
            ->keyword($keyword, $fieldSearch)
            ->publish($publish)
            ->customDropdownFilter($dropdownCondition)
            ->dateRangeFilter($dateRange);

        return $query->orderBy('id', 'desc')->paginate($perpage)->withQueryString();
    }

    public function updateStatusAll($payload)
    {
        $ids = $payload['ids'];
        $value = $payload['value'];
        $columm = [$payload['field'] => $value];
        $confirm = 'confirm';

        return Order::whereIn('code', $ids)->where('confirm', $confirm)->update($columm);
    }

}
