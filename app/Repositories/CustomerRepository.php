<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Repositories\Interfaces\CustomerRepositoryInterface;

class CustomerRepository implements CustomerRepositoryInterface {
    public function paginate($request)
    {
        $perpage = $request->input('perpage') ?? 10;
        $keyword = $request->input('keyword');
        $publish = $request->input('publish');
        $customerCatalougeId = $request->input('customer_catalouge_id');

        $query = Customer::with(
            'province',
            'district',
            'ward',
            'customerCatalouge'
        )
        ->keyword($keyword ?? null)
        ->publish($publish ?? null);


        if((!empty($customerCatalougeId))){
            $query->where('customer_catalouge_id', $customerCatalougeId);
        }


        return $query ->orderBy('id', 'desc')->paginate($perpage)->withQueryString();
    }

    public function create($payload){

        return Customer::create($payload);
    }

    public function update($id, $payload)
    {
        return Customer::find($id)->update($payload);
    }

    public function destroy($id)
    {
        return Customer::destroy($id);
    }


    public function forceDestroy($id)
    {
        return Customer::forceDestroy($id);
    }

    public function updateStatus($payload)
    {
        $modelId = $payload['modelId'];
        $value = $payload['value'] == 1 ? 2 : 1;
        $columm = [ $payload['field'] => $value];

        return Customer::find($modelId)->update($columm);
    }


    public function updateStatusAll($payload)
    {
        $ids = $payload['ids'];
        $value = $payload['value'];
        $columm = [ $payload['field'] => $value];

        return Customer::whereIn('id', $ids)->update($columm);
    }
}
