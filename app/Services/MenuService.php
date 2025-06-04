<?php

namespace App\Services;

use App\Repositories\MenuRepository;
use App\Services\Interfaces\MenuServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


/**
 * Class MenuService
 * @package App\Services
 */
class MenuService implements MenuServiceInterface
{
    protected $menuRepository;

    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    public function paginate($request){
        $menus = $this->menuRepository->paginate($request);
        return $menus;
    }

    public function create($request, $languageId){
        DB::beginTransaction();
        try{
            $payload = $request->except(['_token', 'keyword']);
            if(!empty($payload['menu']['name'])){
                foreach($payload['menu']['name'] as $key => $value){
                    $menuArr =[
                        'menu_catalouge_id' => $payload['menu_catalouge_id'],
                        'menu_type' => $payload['menu_type'],
                        'order' => $payload['menu']['position'][$key],
                        'user_id' => Auth::id(),
                    ];
                    $menu = $this->menuRepository->create($menuArr);

                    $menuLangArr = [
                        'menu_id' => $menu->id,
                       'language_id' => $languageId,
                        'name' => $value,
                        'canonical' => $payload['menu']['canonical'][$key],
                    ];

                    $this->menuRepository->createPivotLanguage($menu, $languageId, $menuLangArr);
                }
            }

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

            $this->menuRepository->update($id, $payload);

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
            $this->menuRepository->destroy($id);

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
            $this->menuRepository->forceDestroy($id);

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
            $this->menuRepository->updateStatus($payload);

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
            $this->menuRepository->updateStatusAll($payload);

            DB::commit();

            return true;
        }catch(\Exception $e){
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }

    public function childSave($request, $parent_id, $parent_menu_catalouge_id, $languageId){
        DB::beginTransaction();
        try{
            $payload = $request->except(['_token', 'keyword']);
            if(!empty($payload['menu']['name'])){
                foreach($payload['menu']['name'] as $key => $value){
                    $menuArr =[
                        'menu_catalouge_id' => $parent_menu_catalouge_id,
                        'parent_id' => $parent_id,
                        'order' => $payload['menu']['position'][$key],
                        'user_id' => Auth::id(),
                    ];

                    $id = null;

                    if($payload['menu']['id'][$key] == 0){
                        $menu = $this->menuRepository->create($menuArr, $parent_id);
                    }else{
                        $id = $payload['menu']['id'][$key];
                        $menu = $this->menuRepository->update($id, $menuArr);
                    }

                    if($menu === null){
                        throw new \Exception('Menu save failed');
                    }


                    $menuLangArr = [
                        'menu_id' => is_null($id) ? $menu->id : $id,
                        'language_id' => $languageId,
                        'name' => $value,
                        'canonical' => $payload['menu']['canonical'][$key],
                    ];

                    $this->menuRepository->createPivotLanguage($menu, $languageId, $menuLangArr);
                }
            }

            DB::commit();

            return true;
        }catch(\Exception $e){
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }


}


