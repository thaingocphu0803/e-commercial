<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\ProductCatalouge;
use App\Models\ProductLanguage;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAll()
    {
        return Product::select('name', 'id')
            ->where('publish', 1)
            ->get();
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

        $attr_catalouge = explode('-', $product->productVariants->first()->attr_catalouge);
        foreach ($product->productVariants as $variant) {
            $attr = explode('-', $variant->code);
            foreach($attr_catalouge as $key => $val){
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

        foreach ($attributes as $key => $val){
            $attributes[$key] = array_values((array_unique($val)));
        }

        $pivot = $product->languages->first()->pivot;
        $pivot['product_catalouge_id'] = $product->product_catalouge_id;
        $pivot['publish'] = $product->publish;
        $pivot['follow'] = $product->follow;
        $pivot['image'] = $product->image;
        $pivot['album'] = $product->album;
        $pivot['catalouges'] = $product->productCatalouges
            ->pluck('pivot.product_catalouge_id')
            ->toArray();

        $pivot['variants'] = [
            'attr_catalouge' => $attr_catalouge,
            'attributes' => $attributes,
            'detail' => $detail,

        ];

        return  $pivot;
    }

    public function findPivotById($id){
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

    // public function updateByWhereIn($ids, $value)
    // {

    //     if (is_array($ids)) {
    //         return User::whereIn('user_catalouge_id', $ids)
    //             ->update(['publish' => $value]);
    //     } else {
    //         $value = $value == 1 ? 2 : 1;
    //         return User::where('user_catalouge_id', $ids)
    //             ->update(['publish' => $value]);
    //     }
    // }
}
