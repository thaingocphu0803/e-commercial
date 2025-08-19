<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Repositories\ProductCatalougeRepository;
use App\Repositories\RouterRepository;
use App\Services\Interfaces\ProductCatalougeServiceInterface;
use Illuminate\Support\Facades\Auth;
use  Illuminate\Support\Str;

/**
 * Class ProductCatalougeService
 * @package App\Services
 */
class ProductCatalougeService implements ProductCatalougeServiceInterface
{
    protected   $productCatalougeRepository;
    protected   $routerRepository;

    public function __construct(ProductCatalougeRepository $productCatalougeRepository, RouterRepository $routeRepository)
    {
        $this->productCatalougeRepository = $productCatalougeRepository;
        $this->routerRepository = $routeRepository;
    }

    public function getAll()
    {
        $productCatalouge = $this->productCatalougeRepository->getAll();
        return $productCatalouge;
    }

    public function paginate($request)
    {
        $languages = $this->productCatalougeRepository->paginate($request);
        return $languages;
    }

    public function getToTree($id = null)
    {
        $productCatalouges = $this->productCatalougeRepository->getToTree($id);
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

        $traverse($productCatalouges);

        return $listNode;
    }

    public function findById($id)
    {
        $productCatalouge = $this->productCatalougeRepository->findById($id);

        return $productCatalouge;
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $payloadProductCatalouge = $request->only($this->getRequestProductCatalouge());

            $payloadProductCatalouge['user_id'] = Auth::id();
            $payloadProductCatalouge['parent_id'] = $request->input('parent_id') ?? null;

            $productCatalouge = $this->productCatalougeRepository->create($payloadProductCatalouge);

            if ($productCatalouge->id > 0) {

                $payloadLanguage = $request->only($this->getRequestPivot());

                $payloadLanguage['product_catalouge_id'] = $productCatalouge->id;
                $payloadLanguage['language_id'] = $request->input('language_id') ?? 1;
                $payloadPivot['canonical'] = Str::slug($payloadLanguage['canonical']);
                $this->productCatalougeRepository->createPivot($productCatalouge, $payloadLanguage);

                $router = $this->getRouterPayload($payloadPivot['canonical'], $productCatalouge->id);
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

            $payloadProductCatalouge = $request->only($this->getRequestProductCatalouge());

            $payloadProductCatalouge['user_id'] = Auth::id();

            $updated = $this->productCatalougeRepository->update($id, $payloadProductCatalouge);

             if($updated > 0){

                $payloadPivot = $request->only($this->getRequestPivot());
                $payloadPivot['canonical'] = Str::slug($payloadPivot['canonical']);
                $this->productCatalougeRepository->UpdatePivot($id, $payloadPivot);

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
            $this->productCatalougeRepository->destroy($id);

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
            $this->productCatalougeRepository->forceDestroy($id);

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
            $this->productCatalougeRepository->updateStatus($payload);

            // $this->productCatalougeRepository->updateByWhereIn($payload['modelId'], $payload['value']);


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
            $this->productCatalougeRepository->updateStatusAll($payload);
            // $this->productCatalougeRepository->updateByWhereIn($payload['ids'], $payload['value']);
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }

    public function loadProductCatalouge($request)
    {
        $productCatalouges = $this->productCatalougeRepository->loadProductCatalouge($request);
        return $productCatalouges;
    }

    public function getRequestProductCatalouge()
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
            'controllers' => 'App\\Http\\Controllers\\Frontend\\ProductCatalougeController'
        ];
    }
}
