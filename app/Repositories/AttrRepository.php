<?php

namespace App\Repositories;

use App\Models\Attr;
use App\Models\AttrCatalouge;
use App\Models\AttrLanguage;
use App\Repositories\Interfaces\AttrRepositoryInterface;

class AttrRepository implements AttrRepositoryInterface
{
    public function getAll()
    {
        return Attr::select('name', 'id')
            ->where('publish', 1)
            ->get();
    }

    public function getToTree()
    {
        $attrCatalouges = AttrCatalouge::with('languages')->orderBy('_lft', 'asc')->get();

        $attrCatalouges = $attrCatalouges->map(function ($attr) {
            if ($attr->languages->isNotEmpty()) {
                $attr['name'] = $attr->languages->first()->pivot->name;
            }
            return $attr;
        });

        return $attrCatalouges->toTree();
    }

    public function findById($id)
    {
        $attr = Attr::with('languages', 'attrCatalouges')->findOrFail($id);
        if ($attr->languages->isEmpty()) {
            return false;
        }
        $pivot = $attr->languages->first()->pivot;
        $pivot['attr_catalouge_id'] = $attr->attr_catalouge_id;
        $pivot['publish'] = $attr->publish;
        $pivot['follow'] = $attr->follow;
        $pivot['image'] = $attr->image;
        $pivot['album'] = $attr->album;
        $pivot['catalouges'] = $attr->attrCatalouges
            ->pluck('pivot.attr_catalouge_id')
            ->toArray();
        return  $pivot;
    }


    public function paginate($request)
    {
        $perpage = $request->input('perpage') ?? 10;
        $keyword = $request->input('keyword');
        $publish = $request->input('publish');
        $attr_catalouge_id = $request->input('attr_catalouge_id');

        $query =  Attr::with('attrCatalouges.languages')->select(
            'attrs.id as id',
            'attrs.image as image',
            'pl.name as name',
            'attrs.publish as publish',
            'attrs.order as order'
        )
            ->join('attr_language as pl', 'pl.attr_id', '=', 'attrs.id')
            ->join('attr_catalouge_attr as pcp', 'pcp.attr_id', '=', 'attrs.id')
            ->keyword($keyword ?? null)
            ->publish($publish ?? null);

        if (!empty($attr_catalouge_id)) {
            $catalouges = $this->getDescendantsAndSelf($attr_catalouge_id);
            if (!empty($catalouges)) {
                $query->WhereIn('attrs.attr_catalouge_id', $catalouges);
            }
        }

        return $query->distinct()->paginate($perpage)->withQueryString();
    }

    public function getDescendantsAndSelf($id)
    {
        return AttrCatalouge::descendantsAndSelf($id)->pluck('id');
    }

    public function create($payload)
    {
        return Attr::create($payload);
    }

    public function createLanguagePivot($model, $payload = [])
    {
        return $model->languages()->attach($model->id, $payload);
    }

    public function createCatalougePivot($model, $payload = [])
    {
        return $model->attrCatalouges()->sync($payload);
    }

    public function updateCatalougePivot($id, $payload = [])
    {
        return Attr::find($id)->attrCatalouges()->sync($payload);
    }


    public function update($id, $payload)
    {
        return Attr::find($id)->update($payload);
    }

    public function updateAttrLanguage($id, $payload = [])
    {
        return AttrLanguage::where('attr_id', $id)
            ->update($payload);
    }

    public function destroy($id)
    {
        return Attr::destroy($id);
    }


    public function forceDestroy($id)
    {
        return Attr::forceDestroy($id);
    }

    public function updateStatus($payload)
    {
        $modelId = $payload['modelId'];
        $value = $payload['value'] == 1 ? 2 : 1;
        $columm = [$payload['field'] => $value];

        return Attr::find($modelId)->update($columm);
    }


    public function updateStatusAll($payload)
    {
        $ids = $payload['ids'];
        $value = $payload['value'];
        $columm = [$payload['field'] => $value];

        return Attr::whereIn('id', $ids)->update($columm);
    }

    public function searchAttr($search, $option)
    {
        return Attr::select('attrs.id', 'al.name as attr_name')
            ->join('attr_catalouge_language as acl', 'attrs.attr_catalouge_id', '=', 'acl.attr_catalouge_id')
            ->join('attr_language as al', 'attrs.id', '=', 'al.attr_id')
            ->where('acl.attr_catalouge_id', $option['attrCatalougeId'])
            ->where('al.name', 'like', '%' . $search . '%')
            ->get();
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
