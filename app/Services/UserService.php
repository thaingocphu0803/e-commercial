<?php

namespace App\Services;

use App\Models\User;
use App\Services\Interfaces\UserServiceInterface;

/**
 * Class UserService
 * @package App\Services
 */
class UserService implements UserServiceInterface
{
    public function paginate($number){
        $users = User::paginate($number);
        return $users;
    }
}
