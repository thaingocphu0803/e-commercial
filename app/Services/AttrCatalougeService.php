<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Repositories\AttrCatalougeRepository;
use App\Repositories\RouterRepository;
use App\Services\Interfaces\AttrCatalougeServiceInterface;
use Illuminate\Support\Facades\Auth;
use  Illuminate\Support\Str;

/**
 * Class AttrCatalougeService
 * @package App\Services
 */
class AttrCatalougeService implements AttrCatalougeServiceInterface
{
    protected   $attrCatalougeRepository;
    protected   $routerRepository;

    public function __construct(AttrCatalougeRepository $attrCatalougeRepository, RouterRepository $routeRepository)
    {
        $this->attrCatalougeRepository = $attrCatalougeRepository;
        $this->routerRepository = $routeRepository;
    }

    public function getAll()
    {
        $userCatalouge = $this->attrCatalougeRepository->getAll();
        return $userCatalouge;
    }

    public function paginate($request)
    {
        $languages = $this->attrCatalougeRepository->paginate($request);
        return $languages;
    }

    public function getToTree($id = null)
    {
        $attrCatalouges = $this->attrCatalougeRepository->getToTree($id);
        $listNode = [];
        $traverse = function ($categories, $prefix = '-') use (&$traverse, &$listNode) {
            foreach ($categories as $category) {
                $listNode[] = (object) [
                    'id' => $category->id,
                    'name' => $prefix . ' ' . $category->name,
                ];

                $traverse($category->children, $prefix . '-');
            }
        };

        $traverse($attrCatalouges);

        return $listNode;
    }

    public function findById($id)
    {
        $attrCatalouge = $this->attrCatalougeRepository->findById($id);

        return $attrCatalouge;
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $payloadAttrCatalouge = $request->only($this->getRequestAttrCatalouge());

            $payloadAttrCatalouge['user_id'] = Auth::id();
            $payloadAttrCatalouge['parent_id'] = $request->input('parent_id') ?? null;

            $attrCatalouge = $this->attrCatalougeRepository->create($payloadAttrCatalouge);

            if ($attrCatalouge->id > 0) {

                $payloadLanguage = $request->only($this->getRequestPivot());

                $payloadLanguage['attr_catalouge_id'] = $attrCatalouge->id;
                $payloadLanguage['language_id'] = $request->input('language_id') ?? 1;
                $payloadPivot['canonical'] = Str::slug($payloadLanguage['canonical']);
                $this->attrCatalougeRepository->createPivot($attrCatalouge, $payloadLanguage);

                $router = $this->getRouterPayload($payloadPivot['canonical'], $attrCatalouge->id);
                $this->routerRepository->create($router);
            }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }

    public function update($id, $request)
    {
        DB::beginTransaction();
        try {

            $payloadAttrCatalouge = $request->only($this->getRequestAttrCatalouge());

            $payloadAttrCatalouge['user_id'] = Auth::id();

            $updated = $this->attrCatalougeRepository->update($id, $payloadAttrCatalouge);

             if($updated > 0){

                $payloadPivot = $request->only($this->getRequestPivot());
                $payloadPivot['canonical'] = Str::slug($payloadPivot['canonical']);
                $this->attrCatalougeRepository->UpdatePivot($id, $payloadPivot);

                $router = $this->getRouterPayload($payloadPivot['canonical'], $id);
                $this->routerRepository->update($router);
             }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }


    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $this->attrCatalougeRepository->destroy($id);

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }


    public function forceDestroy($id)
    {
        DB::beginTransaction();
        try {
            $this->attrCatalougeRepository->forceDestroy($id);

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }

    public function updateStatus($payload)
    {


        DB::beginTransaction();
        try {
            $this->attrCatalougeRepository->updateStatus($payload);

            // $this->attrCatalougeRepository->updateByWhereIn($payload['modelId'], $payload['value']);


            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }

    public function updateStatusAll($payload)
    {

        DB::beginTransaction();
        try {
            $this->attrCatalougeRepository->updateStatusAll($payload);
            // $this->attrCatalougeRepository->updateByWhereIn($payload['ids'], $payload['value']);
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }

    public function getRequestAttrCatalouge()
    {
        return [
            'parent_id',
            'follow',
            'publish',
            'image',
            'album'
        ];
    }


    public function getRequestPivot()
    {
        return [
            'name',
            'description',
            'content',
            'meta_title',
            'meta_keyword',
            'meta_description',
            'canonical',
            'language_id'
        ];
    }

    public function getRouterPayload($canonical, $module_id){
        return [
            'canonical' => $canonical,
            'module_id' => $module_id,
            'controllers' => 'App\\Http\\Controllers\\Frontend\\AttrCatalougeController'
        ];
    }
}
