<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Repositories\ProductRepository;
use App\Repositories\ProductVariantAttrRepository;
use App\Repositories\ProductVariantRepository;
use App\Repositories\RouterRepository;
use App\Services\Interfaces\ProductServiceInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use  Illuminate\Support\Str;
use Ramsey\Uuid\Nonstandard\Uuid;

/**
 * Class ProductService
 * @package App\Services
 */
class ProductService implements ProductServiceInterface
{
    protected   $productRepository;
    protected   $routerRepository;
    protected   $productVariantRepository;
    protected   $productVariantAttrRepository;

    public function __construct(
        ProductRepository $productRepository,
        RouterRepository $routerRepository,
        ProductVariantRepository $productVariantRepository,
        ProductVariantAttrRepository $productVariantAttrRepository
    ) {
        $this->productRepository = $productRepository;
        $this->routerRepository = $routerRepository;
        $this->productVariantAttrRepository = $productVariantAttrRepository;
        $this->productVariantRepository = $productVariantRepository;
    }

    public function getAll()
    {
        $userCatalouge = $this->productRepository->getAll();
        return $userCatalouge;
    }

    public function getWithVariant($request){
        $payload = $request->except('_token');

        return $this->productRepository->getWithVariant($payload);
    }

    public function getWithPromotion(){
        return $this->productRepository->getWithPromotion();
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

                array_push($catalouges, $payloadProduct['product_catalouge_id'] ?? []);

                $payloadCatalouge = array_unique($catalouges);

                $this->productRepository->createCatalougePivot($product, $payloadCatalouge);

                $router = $this->getRouterPayload($payloadPivot['canonical'], $product->id);
                $this->routerRepository->create($router);

                $this->createVariant($product, $request);
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

            if ($updated > 0) {
                $payloadPivot = $request->only($this->getRequestPivot());


                $payloadPivot['canonical'] = Str::slug($payloadPivot['canonical']);

                $this->productRepository->updateproductLanguage($id, $payloadPivot);

                $catalouges = $request->input('catalouge') ?? [];
                array_push($catalouges, $payloadProduct['product_catalouge_id']);

                $payloadCatalouge = array_unique($catalouges);


                $this->productRepository->updateCatalougePivot($id, $payloadCatalouge);

                $router = $this->getRouterPayload($payloadPivot['canonical'], $id);
                $this->routerRepository->update($router);

                $product = $this->productRepository->findPivotById($id);
                $product->productVariants->each(function($variant){
                    $variant->delete();
                    $variant->attrs()->detach();
                });

                $this->createVariant($product, $request);
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

    private function combineAttributes($attributes = [], $index = 0)
    {
        if ($index == count($attributes)) return [[]];

        $subCombines = $this->combineAttributes($attributes, $index + 1);

        $combines = [];

        foreach ($attributes[$index] as $key => $val) {
            foreach ($subCombines as $keySub => $valSub) {
                $combines[] = array_merge([$val], $valSub);
            }
        }

        return $combines;
    }

    public function createVariant($product, $request)
    {
        $payload = $request->only(['variant', 'attr', 'attributes', 'attr-catalouge']);
        // if varinant is not existed, did not anything
        if(!count($payload)) return;
        $variant = $this->createVariantArray($product->id, $payload);

        $variants = $product->productVariants()->createMany($variant);
        $variantIds = $variants->pluck('id');
        $variantAttr = $this->createProductVariantAttrArray($variantIds, $payload['attributes']);

        $this->productVariantAttrRepository->createBash($variantAttr);
    }

    public function createVariantArray($product_id, $payload = []): array
    {
        $attrCatalouge = implode('-', $payload['attr-catalouge']);

        if (isset($payload['variant']['sku']) && count($payload['variant']['sku'])) {
            foreach ($payload['variant']['sku'] as $key => $val) {
                $variant[] = [
                    'uuid' => Uuid::uuid5(Uuid::NAMESPACE_DNS, $product_id. ", ". $payload['attr']['id'][$key]),
                    'user_id' => Auth::id(),
                    'code' => ($payload['attr']['id'][$key]) ?? '',
                    'name' => $payload['attr']['name'][$key],
                    'quantity' => ($payload['variant']['quantity'][$key]) ?? '',
                    'sku' => $val,
                    'price' => ($payload['variant']['price'][$key]) ?? '',
                    'barcode' => ($payload['variant']['barcode'][$key]) ?? '',
                    'filename' => ($payload['variant']['filename'][$key]) ?? '',
                    'url' => ($payload['variant']['url'][$key]) ?? '',
                    'album' => ($payload['variant']['album'][$key]) ?? '',
                    'attr_catalouge' => $attrCatalouge,
                ];
            }
        }

        return $variant;
    }

    public function createProductVariantAttrArray($variantIds, $payload): array
    {

        $attributeCombines = $this->combineAttributes(array_values($payload));
        $variantAttr = [];
        if (count($variantIds) && count($attributeCombines)) {
            foreach ($variantIds as $key => $id) {
                foreach ($attributeCombines[$key] as $attr) {
                    $variantAttr[] = [
                        'product_variant_id' => $id,
                        'attr_id' => $attr,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }
            }
        }

        return $variantAttr;
    }

    public function loadProductWithVariant($request)
    {
       $products  = $this->productRepository->loadProductWithVariant($request);
       return $products;
    }

    public function getRequestPost()
    {
        return [
            'product_id',
            'follow',
            'publish',
            'image',
            'album',
            'product_catalouge_id',
            'code',
            'price'
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
