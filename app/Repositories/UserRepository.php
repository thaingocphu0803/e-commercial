<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface {
    public function paginate($request)
    {
        $perpage = $request->input('perpage') ?? 10;
        $keywork = $request->input('keyword');
        $publish = $request->input('publish');
        $userCatalougeId = $request->input('user_catalouge_id');

        $query = User::with(
            'province',
            'district',
            'ward',
            'userCatalouge'
        )
        ->keyword($keywork ?? null)
        ->publish($publish ?? null);


        if((!empty($userCatalougeId))){
            $query->where('user_catalouge_id', $userCatalougeId);
        }


        return $query ->orderBy('id', 'desc')->paginate($perpage)->withQueryString();
    }

    public function create($payload){

        return User::create($payload);
    }

    public function update($id, $payload)
    {
        return User::find($id)->update($payload);
    }

    public function destroy($id)
    {
        return User::destroy($id);
    }


    public function forceDestroy($id)
    {
        return User::forceDestroy($id);
    }

    public function updateStatus($payload)
    {
        $modelId = $payload['modelId'];
        $value = $payload['value'] == 1 ? 2 : 1;
        $columm = [ $payload['field'] => $value];

        return User::find($modelId)->update($columm);
    }


    public function updateStatusAll($payload)
    {
        $ids = $payload['ids'];
        $value = $payload['value'];
        $columm = [ $payload['field'] => $value];

        return User::whereIn('id', $ids)->update($columm);
    }
}
