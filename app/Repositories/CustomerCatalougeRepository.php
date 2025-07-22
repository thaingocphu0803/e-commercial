<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Models\CustomerCatalouge;
use App\Repositories\Interfaces\CustomerCatalougeRepositoryInterface;

class CustomerCatalougeRepository implements CustomerCatalougeRepositoryInterface
{
    public function getAll()
    {
        return CustomerCatalouge::where('publish', 1)
            ->get();
    }

    public function paginate($request)
    {
        $perpage = $request->input('perpage') ?? 10;
        $keyword = $request->input('keyword');
        $publish = $request->input('publish');

        return CustomerCatalouge::withCount('customers')
        ->keyword($keyword ?? null)
        ->publish($publish ?? null)
        ->orderBy('id', 'desc')
        ->paginate($perpage)
        ->withQueryString();
    }

    public function create($payload)
    {
        return CustomerCatalouge::create($payload);
    }

    public function update($id, $payload)
    {
        return CustomerCatalouge::find($id)->update($payload);
    }

    public function destroy($id)
    {
        return CustomerCatalouge::destroy($id);
    }


    public function forceDestroy($id)
    {
        return CustomerCatalouge::forceDestroy($id);
    }

    public function updateStatus($payload)
    {
        $modelId = $payload['modelId'];
        $value = $payload['value'] == 1 ? 2 : 1;
        $columm = [$payload['field'] => $value];

        return CustomerCatalouge::find($modelId)->update($columm);
    }


    public function updateStatusAll($payload)
    {
        $ids = $payload['ids'];
        $value = $payload['value'];
        $columm = [$payload['field'] => $value];

        return CustomerCatalouge::whereIn('id', $ids)->update($columm);
    }

    public function updateByWhereIn($ids, $value)
    {

        if (is_array($ids)) {
            return Customer::whereIn('customer_catalouge_id', $ids)
                ->update(['publish' => $value]);
        } else {
            $value = $value == 1 ? 2 : 1;
            return Customer::where('customer_catalouge_id', $ids)
                ->update(['publish' => $value]);
        }
    }

}
