<?php

namespace App\Services;

use App\Repositories\UserCatalougeRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class UserCatalougeService
 * @package App\Services
 */
class UserCatalougeService
{
    protected $userCatalougeRepository;

    public function __construct(UserCatalougeRepository $userCatalougeRepository)
    {
        $this->userCatalougeRepository = $userCatalougeRepository;
    }

    public function getAll(){
        $userCatalouge = $this->userCatalougeRepository->getAll();
        return $userCatalouge;
    }

    public function paginate($request){
        $users = $this->userCatalougeRepository->paginate($request);
        return $users;
    }

    public function create($request){
        DB::beginTransaction();
        try{
            $payload = $request->except(['_token']);

            $this->userCatalougeRepository->create($payload);

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

            $this->userCatalougeRepository->update($id, $payload);

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
            $this->userCatalougeRepository->destroy($id);

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
            $this->userCatalougeRepository->forceDestroy($id);

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
            $this->userCatalougeRepository->updateStatus($payload);

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
            $this->userCatalougeRepository->updateStatusAll($payload);

            DB::commit();

            return true;
        }catch(\Exception $e){
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }
}
