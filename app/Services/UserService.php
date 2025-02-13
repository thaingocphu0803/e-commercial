<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


/**
 * Class UserService
 * @package App\Services
 */
class UserService implements UserServiceInterface
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function paginate($number){
        $users = $this->userRepository->getPaginate($number);
        return $users;
    }

    public function create($request){
        DB::beginTransaction();
        try{
            $payload = $request->except(['_token', 'password_confirmation']);

            $payload['password']  = Hash::make($payload['password']);

            $this->userRepository->create($payload);

            DB::commit();

            return true;
        }catch(\Exception $e){
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }

    public function update($id, $request){
        DB::beginTransaction();
        try{
            $payload = $request->except(['_token']);

            $this->userRepository->update($id, $payload);

            DB::commit();

            return true;
        }catch(\Exception $e){
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }
}


