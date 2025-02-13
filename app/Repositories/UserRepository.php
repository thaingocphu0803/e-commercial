<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface {
    public function getPaginate($number)
    {
        return User::orderBy('id', 'desc')->paginate($number);
    }

    public function create($payload){

        return User::create($payload);
    }

    public function update($id, $payload)
    {
        return User::find($id)->update($payload);
    }
}
