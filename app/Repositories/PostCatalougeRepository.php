<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\PostCatalouge;
use App\Models\PostCatalougeLanguage;
use App\Repositories\Interfaces\PostCatalougeRepositoryInterface;

class PostCatalougeRepository implements PostCatalougeRepositoryInterface
{
    public function getAll()
    {
        return PostCatalouge::select('name', 'id')
            ->where('publish', 1)
            ->get();
    }

    public function getToTree()
    {
        $postCatalouges = PostCatalouge::with('languages')->orderBy('_lft', 'asc')->get();

        $postCatalouges = $postCatalouges->map(function ($postCatalouge) {
            if ($postCatalouge->languages->isNotEmpty()) {
                $postCatalouge['name'] = $postCatalouge->languages->first()->pivot->name;
            }
            return $postCatalouge;
        });

        return $postCatalouges->toTree();
    }

    public function findById($id)
    {
        $postCatalouge = PostCatalouge::with('languages')->findOrFail($id);
        if ($postCatalouge->languages->isEmpty()) {
            return false;
        }

        $pivot = $postCatalouge->languages->first()->pivot;
        $pivot['parent_id'] = $postCatalouge->parent_id;
        $pivot['publish'] = $postCatalouge->publish;
        $pivot['follow'] = $postCatalouge->follow;
        $pivot['image'] = $postCatalouge->image;
        $pivot['album'] = $postCatalouge->album;


        return  $pivot;
    }


    public function paginate($request)
    {
        $perpage = $request->input('perpage') ?? 10;
        $keyword = $request->input('keyword');
        $publish = $request->input('publish');

        $query =  PostCatalouge::select(
            'post_catalouges.id as id',
            'post_catalouges.image as image',
            'pcl.name as name',
            'pcl.canonical as canonical',
            'post_catalouges.publish as publish'
        )
            ->join('post_catalouge_language as pcl', 'pcl.post_catalouge_id', '=', 'post_catalouges.id')
            ->where(function ($q) use ($keyword) {
                $q->where('pcl.name', 'like', '%' . $keyword . '%')
                    ->orWhere('pcl.canonical', 'like', '%' . $keyword . '%');
            });

        if (!empty($publish)) {
            $query->where('publish', $publish);
        }

        return $query->orderBy('post_catalouges._lft')->paginate($perpage)->withQueryString();
    }

    public function create($payload)
    {
        $parent = PostCatalouge::find($payload['parent_id']);

        if (!empty($parent)) {
            return $parent->children()->create($payload);
        } else {
            return PostCatalouge::create($payload);
        }
    }

    public function createPivot($model, $payload = [])
    {
        return $model->languages()->attach($model->id, $payload);
    }

    public function update($id, $payload)
    {
        return PostCatalouge::find($id)->update($payload);
    }

    public function UpdatePivot($id, $payload = [])
    {
        return PostCatalougeLanguage::where('post_catalouge_id', $id)
            ->update($payload);
    }

    public function destroy($id)
    {
        $node = PostCatalouge::findOrFail($id);
        $left = $node->_lft;
        $right = $node->_rgt;
        $width = $right - $left + 1;

        $deteted = PostCatalouge::destroy($id);

        if ($deteted) {
            PostCatalouge::where('_lft', '>', $right)->decrement('_lft', $width);
            PostCatalouge::where('_rgt', '>', $right)->decrement('_rgt', $width);

            return true;
        }

        return false;
    }


    public function forceDestroy($id)
    {
        return PostCatalouge::forceDestroy($id);
    }

    public function updateStatus($payload)
    {
        $modelId = $payload['modelId'];
        $value = $payload['value'] == 1 ? 2 : 1;
        $columm = [$payload['field'] => $value];

        return PostCatalouge::find($modelId)->update($columm);
    }


    public function updateStatusAll($payload)
    {
        $ids = $payload['ids'];
        $value = $payload['value'];
        $columm = [$payload['field'] => $value];

        return PostCatalouge::whereIn('id', $ids)->update($columm);
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
