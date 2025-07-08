<?php

namespace App\Services;

use App\Repositories\CustomerRepository;
use App\Services\Interfaces\CustomerServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


/**
 * Class CustomerService
 * @package App\Services
 */
class CustomerService implements CustomerServiceInterface
{
    protected $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function paginate($request){
        $users = $this->customerRepository->paginate($request);
        return $users;
    }

    public function create($request){
        DB::beginTransaction();
        try{
            $payload = $request->except(['_token', 'password_confirmation']);

            $payload['password']  = Hash::make($payload['password']);

            $this->customerRepository->create($payload);

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

            $this->customerRepository->update($id, $payload);

            DB::commit();

            return true;
        }catch(\Exception $e){
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }


    public function destroy($id){
        DB::beginTransaction();
        try{
            $this->customerRepository->destroy($id);

            DB::commit();

            return true;
        }catch(\Exception $e){
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }


    public function forceDestroy($id){
        DB::beginTransaction();
        try{
            $this->customerRepository->forceDestroy($id);

            DB::commit();

            return true;
        }catch(\Exception $e){
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }

    public function updateStatus($payload){
        DB::beginTransaction();
        try{
            $this->customerRepository->updateStatus($payload);

            DB::commit();

            return true;
        }catch(\Exception $e){
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }

    public function updateStatusAll($payload){
        DB::beginTransaction();
        try{
            $this->customerRepository->updateStatusAll($payload);

            DB::commit();

            return true;
        }catch(\Exception $e){
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }
}


