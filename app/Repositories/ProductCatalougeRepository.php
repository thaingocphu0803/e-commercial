<?php

namespace App\Repositories;

use App\Models\ProductCatalouge;
use App\Models\ProductCatalougeLanguage;
use App\Repositories\Interfaces\ProductCatalougeRepositoryInterface;

class ProductCatalougeRepository implements ProductCatalougeRepositoryInterface
{
    public function getAll()
    {
        return ProductCatalouge::select('name', 'id')
            ->where('publish', 1)
            ->get();
    }

    public function getToTree($id = null)
    {
        $productCatalouges = ProductCatalouge::with('languages')->where('id', '!=', $id)->orderBy('_lft', 'asc')->get();

        $productCatalouges = $productCatalouges->map(function ($productCatalouge) {
            if ($productCatalouge->languages->isNotEmpty()) {
                $productCatalouge['name'] = $productCatalouge->languages->first()->pivot->name;
            }
            return $productCatalouge;
        });

        return $productCatalouges->toTree();
    }

    public function findById($id)
    {
        $productCatalouge = ProductCatalouge::with('languages')->findOrFail($id);
        if ($productCatalouge->languages->isEmpty()) {
            return false;
        }

        $pivot = $productCatalouge->languages->first()->pivot;
        $pivot['parent_id'] = $productCatalouge->parent_id;
        $pivot['publish'] = $productCatalouge->publish;
        $pivot['follow'] = $productCatalouge->follow;
        $pivot['image'] = $productCatalouge->image;
        $pivot['album'] = $productCatalouge->album;


        return  $pivot;
    }


    public function paginate($request)
    {
        $perpage = $request->input('perpage') ?? 10;
        $keyword = $request->input('keyword');
        $publish = $request->input('publish');

        $query =  ProductCatalouge::select(
            'product_catalouges.id as id',
            'product_catalouges.image as image',
            'pcl.name as name',
            'pcl.canonical as canonical',
            'product_catalouges.publish as publish'
        )
        ->join('product_catalouge_language as pcl', 'pcl.product_catalouge_id', '=', 'product_catalouges.id')
        ->keyword($keyword ?? null)
        ->publish($publish ?? null);

        return $query->orderBy('product_catalouges._lft')->paginate($perpage)->withQueryString();
    }

    public function create($payload)
    {
        $parent = ProductCatalouge::find($payload['parent_id']);

        if (!empty($parent)) {
            return $parent->children()->create($payload);
        } else {
            return ProductCatalouge::create($payload);
        }
    }

    public function createPivot($model, $payload = [])
    {
        return $model->languages()->attach($model->id, $payload);
    }

    public function update($id, $payload)
    {
        return ProductCatalouge::find($id)->update($payload);
    }

    public function UpdatePivot($id, $payload = [])
    {
        return ProductCatalougeLanguage::where('product_catalouge_id', $id)
            ->update($payload);
    }

    public function destroy($id)
    {
        $node = ProductCatalouge::findOrFail($id);
        $left = $node->_lft;
        $right = $node->_rgt;
        $width = $right - $left + 1;

        $deteted = ProductCatalouge::destroy($id);

        if ($deteted) {
            ProductCatalouge::where('_lft', '>', $right)->decrement('_lft', $width);
            ProductCatalouge::where('_rgt', '>', $right)->decrement('_rgt', $width);

            return true;
        }

        return false;
    }


    public function forceDestroy($id)
    {
        return ProductCatalouge::forceDestroy($id);
    }

    public function updateStatus($payload)
    {
        $modelId = $payload['modelId'];
        $value = $payload['value'] == 1 ? 2 : 1;
        $columm = [$payload['field'] => $value];

        return ProductCatalouge::find($modelId)->update($columm);
    }


    public function updateStatusAll($payload)
    {
        $ids = $payload['ids'];
        $value = $payload['value'];
        $columm = [$payload['field'] => $value];

        return ProductCatalouge::whereIn('id', $ids)->update($columm);
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
