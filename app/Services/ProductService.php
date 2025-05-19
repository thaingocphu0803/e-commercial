<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Repositories\ProductRepository;
use App\Repositories\RouterRepository;
use App\Services\Interfaces\ProductServiceInterface;
use Illuminate\Support\Facades\Auth;
use  Illuminate\Support\Str;

/**
 * Class ProductService
 * @package App\Services
 */
class ProductService implements ProductServiceInterface
{
    protected   $productRepository;
    protected   $routerRepository;

    public function __construct(ProductRepository $productRepository, RouterRepository $routerRepository)
    {
        $this->productRepository = $productRepository;
        $this->routerRepository = $routerRepository;
    }

    public function getAll()
    {
        $userCatalouge = $this->productRepository->getAll();
        return $userCatalouge;
    }

    public function paginate($request)
    {
        $languages = $this->productRepository->paginate($request);
        return $languages;
    }

    public function getToTree()
    {
        $products = $this->productRepository->getToTree();
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

        $traverse($products);

        return $listNode;
    }

    public function findById($id)
    {
        $product = $this->productRepository->findById($id);

        return $product;
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $payloadProduct = $request->only($this->getRequestPost());


            $payloadProduct['user_id'] = Auth::id();
            $payloadProduct['product_catalouge_id'] = $request->input('product_catalouge_id') ?? null;

            $product = $this->productRepository->create($payloadProduct);

            if ($product->id > 0) {

                $payloadLanguage = $request->only($this->getRequestPivot());

                $payloadLanguage['product_id'] = $product->id;
                $payloadLanguage['language_id'] = $request->input('language_id') ?? 1;
                $payloadPivot['canonical'] = Str::slug($payloadLanguage['canonical']);

                $this->productRepository->createLanguagePivot($product, $payloadLanguage);

                $catalouges = $request->input('catalouge') ?? [];

                array_push( $catalouges, $payloadProduct['product_catalouge_id'] ?? [] );

                $payloadCatalouge= array_unique($catalouges);

                $this->productRepository->createCatalougePivot($product, $payloadCatalouge);

                $router = $this->getRouterPayload($payloadPivot['canonical'], $product->id);
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
            $payloadProduct = $request->only($this->getRequestPost());

            $payloadProduct['user_id'] = Auth::id();

            $updated = $this->productRepository->update($id, $payloadProduct);

             if($updated > 0){
                $payloadPivot = $request->only($this->getRequestPivot());


                $payloadPivot['canonical'] = Str::slug($payloadPivot['canonical']);

                $this->productRepository->updateproductLanguage($id, $payloadPivot);

                $catalouges = $request->input('catalouge') ?? [];
                array_push( $catalouges, $payloadProduct['product_catalouge_id'] );

                $payloadCatalouge= array_unique($catalouges);


                $this->productRepository->updateCatalougePivot($id, $payloadCatalouge);

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
            $this->productRepository->destroy($id);

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
            $this->productRepository->forceDestroy($id);

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
            $this->productRepository->updateStatus($payload);

            // $this->productRepository->updateByWhereIn($payload['modelId'], $payload['value']);


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
            $this->productRepository->updateStatusAll($payload);
            // $this->productRepository->updateByWhereIn($payload['ids'], $payload['value']);
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }

    public function getRequestPost()
    {
        return [
            'product_id',
            'follow',
            'publish',
            'image',
            'album',
            'product_catalouge_id'
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

    public function getRouterPayload($canonical, $module_id)
    {
        return [
            'canonical' => $canonical,
            'module_id' => $module_id,
            'controllers' => 'App\\Http\\Controllers\\Frontend\\ProductController'
        ];
    }
}
