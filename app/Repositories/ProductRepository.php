<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\ProductCatalouge;
use App\Models\ProductLanguage;
use App\Models\ProductVariant;
use App\Models\Promotion;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAll()
    {
        return Product::select('name', 'id')
            ->where('publish', 1)
            ->get();
    }

    public function getWithPromotion()
    {

        $lowestPriceSub = ProductVariant::select('product_id', DB::raw('MIN(price) as min_price'))
                          ->groupBy('product_id');

        $discountSub = Promotion::select(
            'ppv.product_id',
            'promotions.discountValue',
            'promotions.discountType',
            DB::raw("
                MIN(
                    IF(
                        promotions.maxDiscountValue != 0,
                        LEAST(
                            CASE
                                WHEN promotions.discountType='amount' THEN promotions.discountValue
                                WHEN promotions.discountType='percent' THEN COALESCE(lp.min_price, p.price) * (promotions.discountValue/100)
                            ELSE 0
                            END,
                            promotions.maxDiscountValue
                        ),
                        CASE
                            WHEN promotions.discountType='amount' THEN promotions.discountValue
                            WHEN promotions.discountType='percent' THEN COALESCE(lp.min_price, p.price) * (promotions.discountValue/100)
                        ELSE 0

                        END
                    )
                ) as discount
            ")
        )
            ->join('promotion_product_variant as ppv', 'promotions.id', '=', 'ppv.promotion_id')
            ->join('products as p', 'p.id', '=', 'ppv.product_id')
            ->leftJoinSub($lowestPriceSub, 'lp', function($join){
                $join->on('p.id', '=', 'lp.product_id');
            })
            ->where('ppv.model', 'product')
            ->where(function ($q) {
                $q->whereNull('promotions.end_date')
                    ->orWhere('promotions.end_date', '>', now());
            })
            ->groupBy(
                'ppv.product_id',
                'promotions.discountValue',
                'promotions.discountType',
            );

        $products = Product::select(
            'products.image',
            'products.album',
            'products.code',
            DB::raw('MIN(COALESCE(lp.min_price, products.price)) as product_price'),
            'pl.name as product_name', 'discount_sub.discount',
            'pcl.name as product_catalouge_name',
            'pcl.canonical as product_catalouge_canonical',
            'pl.canonical as product_canonical',
            'discount_sub.discountValue',
            'discount_sub.discountType'
            )
            ->join('product_language as pl', 'products.id', '=', 'pl.product_id')
            ->join('product_catalouge_language as pcl', 'products.product_catalouge_id', '=', 'pcl.product_catalouge_id')
            ->leftJoinSub($lowestPriceSub, 'lp', function($join){
                $join->on('products.id', '=', 'lp.product_id');
            })
            ->leftJoinSub($discountSub, 'discount_sub', function ($join) {
                $join->on('products.id', '=', 'discount_sub.product_id');
            })
            ->groupBy(
                'products.id',
                'products.image',
                'products.album',
                'products.code',
                'pl.name',
                'discount_sub.discount',
                'pcl.name',
                'pcl.canonical',
                'pl.canonical',
                'discount_sub.discountValue',
                'discount_sub.discountType'
            )
            ->paginate(30);

        return $products;
    }

    public function getToTree()
    {
        $productCatalouges = ProductCatalouge::with('languages')->orderBy('_lft', 'asc')->get();

        $productCatalouges = $productCatalouges->map(function ($product) {
            if ($product->languages->isNotEmpty()) {
                $product['name'] = $product->languages->first()->pivot->name;
            }
            return $product;
        });

        return $productCatalouges->toTree();
    }

    public function findById($id)
    {
        $product = Product::with([
            'languages',
            'productCatalouges',
            'productVariants' => function ($q) {
                $q->with(['attrs' => function ($q) {
                    $q->with(['attrLanguage']);
                }]);
            }
        ])->findOrFail($id);


        if ($product->languages->isEmpty()) {
            return false;
        }

        $pivot = $product->languages->first()->pivot;
        $pivot['product_catalouge_id'] = $product->product_catalouge_id;
        $pivot['publish'] = $product->publish;
        $pivot['code'] = $product->code;
        $pivot['price'] = $product->price;
        $pivot['follow'] = $product->follow;
        $pivot['image'] = $product->image;
        $pivot['album'] = $product->album;
        $pivot['catalouges'] = $product->productCatalouges
            ->pluck('pivot.product_catalouge_id')
            ->toArray();

        if (count($product->productVariants)) {
            $attr_catalouge = explode('-', $product->productVariants->first()->attr_catalouge);
            foreach ($product->productVariants as $variant) {
                $attr = explode('-', $variant->code);

                foreach ($attr_catalouge as $key => $val) {
                    $attributes[$val][] = $attr[$key];
                }

                $detail['quantity'][] = $variant->quantity;
                $detail['sku'][] = $variant->sku;
                $detail['price'][] = $variant->price;
                $detail['barcode'][] = $variant->barcode;
                $detail['filename'][] = $variant->filename;
                $detail['url'][] = $variant->url;
                $detail['album'][] = $variant->album;
            }

            foreach ($attributes as $key => $val) {
                $attributes[$key] = array_values((array_unique($val)));
            }

            $pivot['variants'] = [
                'attr_catalouge' => $attr_catalouge,
                'attributes' => $attributes,
                'detail' => $detail,

            ];
        }

        return  $pivot;
    }

    public function findPivotById($id)
    {
        return Product::with([
            'languages',
            'productCatalouges',
            'productVariants' => function ($q) {
                $q->with(['attrs' => function ($q) {
                    $q->with(['attrLanguage']);
                }]);
            }
        ])->findOrFail($id);
    }


    public function paginate($request)
    {
        $perpage = $request->input('perpage') ?? 10;
        $keyword = $request->input('keyword');
        $publish = $request->input('publish');
        $product_catalouge_id = $request->input('product_catalouge_id');

        $query =  Product::with('productCatalouges.languages')->select(
            'products.id as id',
            'products.image as image',
            'pl.name as name',
            'pl.canonical as canonical',
            'products.publish as publish',
            'products.order as order'
        )
            ->join('product_language as pl', 'pl.product_id', '=', 'products.id')
            ->join('product_catalouge_product as pcp', 'pcp.product_id', '=', 'products.id')
            ->keyword($keyword ?? null)
            ->publish($publish ?? null);

        if (!empty($product_catalouge_id)) {
            $catalouges = $this->getDescendantsAndSelf($product_catalouge_id);
            if (!empty($catalouges)) {
                $query->WhereIn('products.product_catalouge_id', $catalouges);
            }
        }

        return $query->distinct()->paginate($perpage)->withQueryString();
    }

    public function getDescendantsAndSelf($id)
    {
        return ProductCatalouge::descendantsAndSelf($id)->pluck('id');
    }

    public function create($payload)
    {
        return Product::create($payload);
    }

    public function createLanguagePivot($model, $payload = [])
    {
        return $model->languages()->attach($model->id, $payload);
    }

    public function createCatalougePivot($model, $payload = [])
    {
        return $model->productCatalouges()->sync($payload);
    }

    public function updateCatalougePivot($id, $payload = [])
    {
        return Product::find($id)->productCatalouges()->sync($payload);
    }


    public function update($id, $payload)
    {
        return Product::find($id)->update($payload);
    }

    public function updateProductLanguage($id, $payload = [])
    {
        return ProductLanguage::where('product_id', $id)
            ->update($payload);
    }

    public function destroy($id)
    {
        return Product::destroy($id);
    }


    public function forceDestroy($id)
    {
        return Product::forceDestroy($id);
    }

    public function updateStatus($payload)
    {
        $modelId = $payload['modelId'];
        $value = $payload['value'] == 1 ? 2 : 1;
        $columm = [$payload['field'] => $value];

        return Product::find($modelId)->update($columm);
    }


    public function updateStatusAll($payload)
    {
        $ids = $payload['ids'];
        $value = $payload['value'];
        $columm = [$payload['field'] => $value];

        return Product::whereIn('id', $ids)->update($columm);
    }

    public function loadProductWithVariant($request)
    {
        $keyword = $request->input('keyword');

        return Product::selectRaw(
            "
                products.id,
                products.image,
                tb3.uuid as variant_uuid,
                CONCAT(tb2.name, ' | ', COALESCE(tb3.name, 'default')) as product_name,
                COALESCE(tb3.sku, products.code) as sku,
                COALESCE(tb3.price, products.price) as price
            "
        )
            ->join('product_language as tb2', 'products.id', '=', 'tb2.product_id')
            ->leftJoin('product_variants as tb3', 'products.id', '=', 'tb3.product_id')
            ->where('tb2.name', 'like', '%' . $keyword . '%')
            ->paginate(10)->withQueryString();
    }
}
