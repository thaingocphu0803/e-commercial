<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Repositories\AttrRepository;
use App\Repositories\RouterRepository;
use App\Services\Interfaces\AttrServiceInterface;
use Illuminate\Support\Facades\Auth;
use  Illuminate\Support\Str;

/**
 * Class AttrService
 * @package App\Services
 */
class AttrService implements AttrServiceInterface
{
    protected   $attrRepository;
    protected   $routerRepository;

    public function __construct(AttrRepository $attrRepository, RouterRepository $routerRepository)
    {
        $this->attrRepository = $attrRepository;
        $this->routerRepository = $routerRepository;
    }

    public function getAll()
    {
        $userCatalouge = $this->attrRepository->getAll();
        return $userCatalouge;
    }

    public function paginate($request)
    {
        $languages = $this->attrRepository->paginate($request);
        return $languages;
    }

    public function getToTree()
    {
        $attrs = $this->attrRepository->getToTree();
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

        $traverse($attrs);

        return $listNode;
    }

    public function findById($id)
    {
        $attr = $this->attrRepository->findById($id);

        return $attr;
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $payloadAttr = $request->only($this->getRequestPost());


            $payloadAttr['user_id'] = Auth::id();
            $payloadAttr['attr_catalouge_id'] = $request->input('attr_catalouge_id') ?? null;

            $attr = $this->attrRepository->create($payloadAttr);

            if ($attr->id > 0) {

                $payloadLanguage = $request->only($this->getRequestPivot());

                $payloadLanguage['attr_id'] = $attr->id;
                $payloadLanguage['language_id'] = $request->input('language_id') ?? 1;
                $payloadPivot['canonical'] = Str::slug($payloadLanguage['canonical']);

                $this->attrRepository->createLanguagePivot($attr, $payloadLanguage);

                $catalouges = $request->input('catalouge') ?? [];

                array_push( $catalouges, $payloadAttr['attr_catalouge_id'] ?? [] );

                $payloadCatalouge= array_unique($catalouges);

                $this->attrRepository->createCatalougePivot($attr, $payloadCatalouge);

                $router = $this->getRouterPayload($payloadPivot['canonical'], $attr->id);
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
            $payloadAttr = $request->only($this->getRequestPost());

            $payloadAttr['user_id'] = Auth::id();

            $updated = $this->attrRepository->update($id, $payloadAttr);

             if($updated > 0){
                $payloadPivot = $request->only($this->getRequestPivot());


                $payloadPivot['canonical'] = Str::slug($payloadPivot['canonical']);

                $this->attrRepository->updateattrLanguage($id, $payloadPivot);

                $catalouges = $request->input('catalouge') ?? [];
                array_push( $catalouges, $payloadAttr['attr_catalouge_id'] );

                $payloadCatalouge= array_unique($catalouges);


                $this->attrRepository->updateCatalougePivot($id, $payloadCatalouge);

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
            $this->attrRepository->destroy($id);

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
            $this->attrRepository->forceDestroy($id);

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
            $this->attrRepository->updateStatus($payload);

            // $this->attrRepository->updateByWhereIn($payload['modelId'], $payload['value']);


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
            $this->attrRepository->updateStatusAll($payload);
            // $this->attrRepository->updateByWhereIn($payload['ids'], $payload['value']);
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
            'attr_id',
            'follow',
            'publish',
            'image',
            'album',
            'attr_catalouge_id'
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
            'controllers' => 'App\\Http\\Controllers\\Frontend\\AttrController'
        ];
    }
}
