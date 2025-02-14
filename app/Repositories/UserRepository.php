<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface {
    public function getPaginate($request)
    {
        $perpage = $request->input('perpage') ?? 20;
        $keywork = $request->input('keyword');
        return User::where('name', 'like', '%'.$keywork.'%')
                    ->orWhere('email', 'like', '%'.$keywork.'%')
                    ->orderBy('id', 'desc')
                    ->paginate($perpage)
                    ->withQueryString();
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
        $value = $payload['value'] == 1 ? 0 : 1;
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
