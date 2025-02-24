<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\PostCatalouge;
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
        $postCatalouges =  PostCatalouge::with('languages')->orderBy('_lft', 'asc')->get();

        foreach($postCatalouges as &$postCatalouge){
            foreach($postCatalouge->languages as $postCatalougeLanguage){
                $postCatalouge['name'] = $postCatalougeLanguage->pivot->name;
            }
        }

       return $postCatalouges->toTree();
    }

    public function paginate($request)
    {
        $perpage = $request->input('perpage') ?? 10;
        $keywork = $request->input('keyword');
        $publish = $request->input('publish');

        $query =  PostCatalouge::where(function ($q) use ($keywork){
                                    $q->where('album', 'like', '%' . $keywork . '%')
                                    ->orWhere('icon', 'like', '%' . $keywork . '%');
                                });

        if (!empty($publish)) {
            $query->where('publish', $publish);
        }

        return $query->orderBy('id', 'desc')->paginate($perpage)->withQueryString();
    }

    public function create($payload)
    {
        $parent = PostCatalouge::find( $payload['parent_id']);

        if(!empty($parent)){
            return $parent->children()->create($payload);
        }else{
            return PostCatalouge::create($payload);
        }
    }

    public function update($id, $payload)
    {
        return PostCatalouge::find($id)->update($payload);
    }

    public function destroy($id)
    {
        return PostCatalouge::destroy($id);
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

    public function createPivotLanguage($model, $payload = []){
        return $model->languages()->attach($model->id, $payload);
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
