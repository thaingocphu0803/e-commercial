<?php

namespace App\Repositories;

use App\Models\AttrCatalouge;
use App\Models\AttrCatalougeLanguage;
use App\Repositories\Interfaces\AttrCatalougeRepositoryInterface;

class AttrCatalougeRepository implements AttrCatalougeRepositoryInterface
{
    public function getAll()
    {
        return AttrCatalouge::select('name', 'id')
            ->where('publish', 1)
            ->get();
    }

    public function getToTree($id = null)
    {
        $attrCatalouges = AttrCatalouge::with('languages')->where('id', '!=', $id)->orderBy('_lft', 'asc')->get();

        $attrCatalouges = $attrCatalouges->map(function ($attrCatalouge) {
            if ($attrCatalouge->languages->isNotEmpty()) {
                $attrCatalouge['name'] = $attrCatalouge->languages->first()->pivot->name;
            }
            return $attrCatalouge;
        });

        return $attrCatalouges->toTree();
    }

    public function findById($id)
    {
        $attrCatalouge = AttrCatalouge::with('languages')->findOrFail($id);
        if ($attrCatalouge->languages->isEmpty()) {
            return false;
        }

        $pivot = $attrCatalouge->languages->first()->pivot;
        $pivot['parent_id'] = $attrCatalouge->parent_id;
        $pivot['publish'] = $attrCatalouge->publish;
        $pivot['follow'] = $attrCatalouge->follow;
        $pivot['image'] = $attrCatalouge->image;
        $pivot['album'] = $attrCatalouge->album;


        return  $pivot;
    }


    public function paginate($request)
    {
        $perpage = $request->input('perpage') ?? 10;
        $keyword = $request->input('keyword');
        $publish = $request->input('publish');

        $query =  AttrCatalouge::select(
            'attr_catalouges.id as id',
            'attr_catalouges.image as image',
            'pcl.name as name',
            'pcl.canonical as canonical',
            'attr_catalouges.publish as publish'
        )
        ->join('attr_catalouge_language as pcl', 'pcl.attr_catalouge_id', '=', 'attr_catalouges.id')
        ->keyword($keyword ?? null)
        ->publish($publish ?? null);

        return $query->orderBy('attr_catalouges._lft')->paginate($perpage)->withQueryString();
    }

    public function create($payload)
    {
        $parent = AttrCatalouge::find($payload['parent_id']);

        if (!empty($parent)) {
            return $parent->children()->create($payload);
        } else {
            return AttrCatalouge::create($payload);
        }
    }

    public function createPivot($model, $payload = [])
    {
        return $model->languages()->attach($model->id, $payload);
    }

    public function update($id, $payload)
    {
        return AttrCatalouge::find($id)->update($payload);
    }

    public function UpdatePivot($id, $payload = [])
    {
        return AttrCatalougeLanguage::where('attr_catalouge_id', $id)
            ->update($payload);
    }

    public function destroy($id)
    {
        $node = AttrCatalouge::findOrFail($id);
        $left = $node->_lft;
        $right = $node->_rgt;
        $width = $right - $left + 1;

        $deteted = AttrCatalouge::destroy($id);

        if ($deteted) {
            AttrCatalouge::where('_lft', '>', $right)->decrement('_lft', $width);
            AttrCatalouge::where('_rgt', '>', $right)->decrement('_rgt', $width);

            return true;
        }

        return false;
    }


    public function forceDestroy($id)
    {
        return AttrCatalouge::forceDestroy($id);
    }

    public function updateStatus($payload)
    {
        $modelId = $payload['modelId'];
        $value = $payload['value'] == 1 ? 2 : 1;
        $columm = [$payload['field'] => $value];

        return AttrCatalouge::find($modelId)->update($columm);
    }


    public function updateStatusAll($payload)
    {
        $ids = $payload['ids'];
        $value = $payload['value'];
        $columm = [$payload['field'] => $value];

        return AttrCatalouge::whereIn('id', $ids)->update($columm);
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
