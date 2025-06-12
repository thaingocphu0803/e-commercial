<?php

namespace App\Services;

use App\Repositories\MenuCatalougeRepository;
use App\Services\Interfaces\MenuCatalougeServiceInterface;
use Illuminate\Support\Facades\DB;
use  Illuminate\Support\Str;


/**
 * Class MenuCatalougeService
 * @package App\Services
 */
class MenuCatalougeService implements MenuCatalougeServiceInterface
{
    protected $menuCatalougeRepository;

    public function __construct(MenuCatalougeRepository $menuCatalougeRepository)
    {
        $this->menuCatalougeRepository = $menuCatalougeRepository;
    }

    public function paginate($request){
        $menuCatalouge = $this->menuCatalougeRepository->paginate($request);
        return $menuCatalouge;
    }

    public function getAll(){
        $menuCatalouges = $this->menuCatalougeRepository->getAll();
        return $menuCatalouges;
    }

    public function findById($id){
        $menuCatalouge = $this->menuCatalougeRepository->findById($id);
        return $menuCatalouge;
    }

    public function create($request){
        DB::beginTransaction();
        try{
            $payload = $request->except(['_token']);
            $payload['keyword'] = Str::slug($payload['keyword']);

            $menuCatalouge = $this->menuCatalougeRepository->create($payload);
            DB::commit();

            return (object) [
                'name' => $menuCatalouge->name,
                'id' => $menuCatalouge->id,
            ];
        }catch(\Exception $e){
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }

    public function forceDestroy($id){
        DB::beginTransaction();
        try{
            $this->menuCatalougeRepository->forceDestroy($id);

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
            $this->menuCatalougeRepository->updateStatus($payload);

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
            $this->menuCatalougeRepository->updateStatusAll($payload);

            DB::commit();

            return true;
        }catch(\Exception $e){
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }


}


