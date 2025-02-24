<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Repositories\PostCatalougeRepository;
use Illuminate\Support\Facades\Auth;


/**
 * Class postCatalougeService
 * @package App\Services
 */
class PostCatalougeService
{
    protected   $postCatalougeRepository;

    public function __construct(PostCatalougeRepository $postCatalougeRepository)
    {
        $this->postCatalougeRepository = $postCatalougeRepository;
    }

    public function getAll()
    {
        $userCatalouge = $this->postCatalougeRepository->getAll();
        return $userCatalouge;
    }

    public function paginate($request)
    {
        $languages = $this->postCatalougeRepository->paginate($request);
        return $languages;
    }

    public function getToTree(){
        $postCatalouges = $this->postCatalougeRepository->getToTree();
        $listNode= [];
        $traverse = function ($categories, $prefix = '-') use (&$traverse, &$listNode) {
            foreach ($categories as $category) {
                $listNode[] = (object) [
                    'id' => $category->name,
                    'name' => $prefix.' '.$category->name,
                ];

                $traverse($category->children, $prefix.'-');
            }
        };

        $traverse($postCatalouges);

         return $listNode;
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $payloadPostCatalouge = $request->only([
                'parent_id',
                'follow',
                'publish',
                'image'
            ]);

            $payloadPostCatalouge['user_id'] = Auth::id();
            $payloadPostCatalouge['parent_id'] = $request->input('parent_id') ?? null;

            $postCatalouge = $this->postCatalougeRepository->create($payloadPostCatalouge);

            if($postCatalouge->id > 0){

                $payloadLanguage = $request->only([
                    'name',
                    'description',
                    'content',
                    'meta_title',
                    'meta_keyword',
                    'meta_description',
                    'canonical',
                    'language_id'
                ]);

                $payloadLanguage['post_catalouge_id'] = $postCatalouge->id;
                $payloadLanguage['language_id'] = $request->input('language_id') ?? 1;

                $this->postCatalougeRepository->createPivotLanguage($postCatalouge, $payloadLanguage);
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
            $payload = $request->except(['_token']);

            $this->postCatalougeRepository->update($id, $payload);

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
            $this->postCatalougeRepository->destroy($id);

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
            $this->postCatalougeRepository->forceDestroy($id);

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
            $this->postCatalougeRepository->updateStatus($payload);

            // $this->postCatalougeRepository->updateByWhereIn($payload['modelId'], $payload['value']);


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
            $this->postCatalougeRepository->updateStatusAll($payload);
            // $this->postCatalougeRepository->updateByWhereIn($payload['ids'], $payload['value']);
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }
}
