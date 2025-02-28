<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\PostCatalouge;
use App\Models\PostLanguage;
use App\Repositories\Interfaces\PostRepositoryInterface;

class PostRepository implements PostRepositoryInterface
{
    public function getAll()
    {
        return Post::select('name', 'id')
            ->where('publish', 1)
            ->get();
    }

    public function getToTree()
    {
        $postCatalouges = PostCatalouge::with('languages')->orderBy('_lft', 'asc')->get();

        $postCatalouges = $postCatalouges->map(function ($post) {
            if ($post->languages->isNotEmpty()) {
                $post['name'] = $post->languages->first()->pivot->name;
            }
            return $post;
        });

        return $postCatalouges->toTree();
    }

    public function findById($id)
    {
        $post = Post::with('languages', 'postCatalouges')->findOrFail($id);
        if ($post->languages->isEmpty()) {
            return false;
        }
        $pivot = $post->languages->first()->pivot;
        $pivot['post_catalouge_id'] = $post->post_catalouge_id;
        $pivot['publish'] = $post->publish;
        $pivot['follow'] = $post->follow;
        $pivot['image'] = $post->image;
        $pivot['album'] = $post->album;
        $pivot['catalouges'] = $post->postCatalouges
                                ->pluck('pivot.post_catalouge_id')
                                ->toArray();
        return  $pivot;
    }


    public function paginate($request)
    {
        $perpage = $request->input('perpage') ?? 10;
        $keyword = $request->input('keyword');
        $publish = $request->input('publish');
        $post_catalouge_id = $request->input('post_catalouge_id');

        $query =  Post::with('postCatalouges.languages')->select(
            'posts.id as id',
            'posts.image as image',
            'pl.name as name',
            'posts.publish as publish',
            'posts.order as order'
        )
        ->join('post_language as pl', 'pl.post_id', '=', 'posts.id')
        ->join('post_catalouge_post as pcp', 'pcp.post_id', '=', 'posts.id')
        ->keyword($keyword ?? null)
        ->publish($publish ?? null);

        if(!empty($post_catalouge_id)){
            $catalouges = $this->getDescendantsAndSelf($post_catalouge_id);
            if(!empty($catalouges)){
                $query->WhereIn('posts.post_catalouge_id', $catalouges);
            }
        }

        return $query->distinct()->paginate($perpage)->withQueryString();
    }

    public function getDescendantsAndSelf($id)
    {
        return PostCatalouge::descendantsAndSelf($id)->pluck('id');
    }

    public function create($payload)
    {
            return Post::create($payload);
    }

    public function createLanguagePivot($model, $payload = [])
    {
        return $model->languages()->attach($model->id, $payload);
    }

    public function createCatalougePivot($model, $payload = [])
    {
        return $model->postCatalouges()->sync($payload);
    }

    public function updateCatalougePivot($id, $payload = [])
    {
        return Post::find($id)->postCatalouges()->sync($payload);
    }


    public function update($id, $payload)
    {
        return Post::find($id)->update($payload);
    }

    public function updatePostLanguage($id, $payload = [])
    {
        return PostLanguage::where('post_id', $id)
            ->update($payload);
    }

    public function destroy($id)
    {
        return Post::destroy($id);
    }


    public function forceDestroy($id)
    {
        return Post::forceDestroy($id);
    }

    public function updateStatus($payload)
    {
        $modelId = $payload['modelId'];
        $value = $payload['value'] == 1 ? 2 : 1;
        $columm = [$payload['field'] => $value];

        return Post::find($modelId)->update($columm);
    }


    public function updateStatusAll($payload)
    {
        $ids = $payload['ids'];
        $value = $payload['value'];
        $columm = [$payload['field'] => $value];

        return Post::whereIn('id', $ids)->update($columm);
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
