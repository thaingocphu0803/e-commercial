<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Repositories\PostRepository;
use App\Repositories\RouterRepository;
use App\Services\Interfaces\PostServiceInterface;
use Illuminate\Support\Facades\Auth;
use  Illuminate\Support\Str;

/**
 * Class postService
 * @package App\Services
 */
class PostService implements PostServiceInterface
{
    protected   $postRepository;
    protected   $routerRepository;

    public function __construct(PostRepository $postRepository, RouterRepository $routerRepository)
    {
        $this->postRepository = $postRepository;
        $this->routerRepository = $routerRepository;
    }

    public function getAll()
    {
        $userCatalouge = $this->postRepository->getAll();
        return $userCatalouge;
    }

    public function paginate($request)
    {
        $languages = $this->postRepository->paginate($request);
        return $languages;
    }

    public function getToTree()
    {
        $postCatalouges = $this->postRepository->getToTree();
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

        $traverse($postCatalouges);

        return $listNode;
    }

    public function findById($id)
    {
        $post = $this->postRepository->findById($id);

        return $post;
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $payloadPost = $request->only($this->getRequestPost());


            $payloadPost['user_id'] = Auth::id();
            $payloadPost['post_catalouge_id'] = $request->input('post_catalouge_id') ?? null;

            $post = $this->postRepository->create($payloadPost);

            if ($post->id > 0) {

                $payloadLanguage = $request->only($this->getRequestPivot());

                $payloadLanguage['post_id'] = $post->id;
                $payloadLanguage['language_id'] = $request->input('language_id') ?? 1;
                $payloadPivot['canonical'] = Str::slug($payloadLanguage['canonical']);

                $this->postRepository->createLanguagePivot($post, $payloadLanguage);

                $catalouges = $request->input('catalouge') ?? [];

                array_push( $catalouges, $payloadPost['post_catalouge_id'] ?? [] );

                $payloadCatalouge= array_unique($catalouges);

                $this->postRepository->createCatalougePivot($post, $payloadCatalouge);

                $router = $this->getRouterPayload($payloadPivot['canonical'], $post->id);
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
            $payloadPost = $request->only($this->getRequestPost());

            $payloadPost['user_id'] = Auth::id();

            $updated = $this->postRepository->update($id, $payloadPost);

             if($updated > 0){
                $payloadPivot = $request->only($this->getRequestPivot());


                $payloadPivot['canonical'] = Str::slug($payloadPivot['canonical']);

                $this->postRepository->updatePostLanguage($id, $payloadPivot);

                $catalouges = $request->input('catalouge') ?? [];
                array_push( $catalouges, $payloadPost['post_catalouge_id'] );

                $payloadCatalouge= array_unique($catalouges);


                $this->postRepository->updateCatalougePivot($id, $payloadCatalouge);

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
            $this->postRepository->destroy($id);

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
            $this->postRepository->forceDestroy($id);

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
            $this->postRepository->updateStatus($payload);

            // $this->postRepository->updateByWhereIn($payload['modelId'], $payload['value']);


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
            $this->postRepository->updateStatusAll($payload);
            // $this->postRepository->updateByWhereIn($payload['ids'], $payload['value']);
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
            'post_id',
            'follow',
            'publish',
            'image',
            'album',
            'post_catalouge_id'
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
            'controllers' => 'App\\Http\\Controllers\\Frontend\\PostController'
        ];
    }
}
