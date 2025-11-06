<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Repositories\{ModuleName}Repository;
use App\Repositories\RouterRepository;
use App\Services\Interfaces\{ModuleName}ServiceInterface;
use Illuminate\Support\Facades\Auth;
use  Illuminate\Support\Str;

/**
 * Class {ModuleName}Service
 * @package App\Services
 */
class {ModuleName}Service implements {ModuleName}ServiceInterface
{
    protected   ${moduleName}Repository;
    protected   $routerRepository;

    public function __construct({ModuleName}Repository ${moduleName}Repository, RouterRepository $routeRepository)
    {
        $this->{moduleName}Repository = ${moduleName}Repository;
        $this->routerRepository = $routeRepository;
    }

    public function getAll()
    {
        $userCatalouge = $this->{moduleName}Repository->getAll();
        return $userCatalouge;
    }

    public function paginate($request)
    {
        $languages = $this->{moduleName}Repository->paginate($request);
        return $languages;
    }

    public function getToTree($id = null)
    {
        ${moduleName}s = $this->{moduleName}Repository->getToTree($id);
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

        $traverse(${moduleName}s);

        return $listNode;
    }

    public function findById($id)
    {
        ${moduleName} = $this->{moduleName}Repository->findById($id);

        return ${moduleName};
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $payload{ModuleName} = $request->only($this->getRequest{ModuleName}());

            $payload{ModuleName}['user_id'] = Auth::id();
            $payload{ModuleName}['parent_id'] = $request->input('parent_id') ?? null;

            ${moduleName} = $this->{moduleName}Repository->create($payload{ModuleName});

            if (${moduleName}->id > 0) {

                $payloadLanguage = $request->only($this->getRequestPivot());

                $payloadLanguage['{moduleTableName}_id'] = ${moduleName}->id;
                $payloadLanguage['language_id'] = $request->input('language_id') ?? 1;
                $payloadPivot['canonical'] = Str::slug($payloadLanguage['canonical']);
                $this->{moduleName}Repository->createPivot(${moduleName}, $payloadLanguage);

                $router = $this->getRouterPayload($payloadPivot['canonical'], ${moduleName}->id);
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

            $payload{ModuleName} = $request->only($this->getRequest{ModuleName}());

            $payload{ModuleName}['user_id'] = Auth::id();

            $updated = $this->{moduleName}Repository->update($id, $payload{ModuleName});

             if($updated > 0){

                $payloadPivot = $request->only($this->getRequestPivot());
                $payloadPivot['canonical'] = Str::slug($payloadPivot['canonical']);
                $this->{moduleName}Repository->UpdatePivot($id, $payloadPivot);

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
            $this->{moduleName}Repository->destroy($id);

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
            $this->{moduleName}Repository->forceDestroy($id);

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
            $this->{moduleName}Repository->updateStatus($payload);

            // $this->{moduleName}Repository->updateByWhereIn($payload['modelId'], $payload['value']);


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
            $this->{moduleName}Repository->updateStatusAll($payload);
            // $this->{moduleName}Repository->updateByWhereIn($payload['ids'], $payload['value']);
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }

    public function getRequest{ModuleName}()
    {
        return [
            'parent_id',
            'follow',
            'publish',
            'image',
            'album'
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

    public function getRouterPayload($canonical, $module_id){
        return [
            'canonical' => $canonical,
            'module_id' => $module_id,
            'controllers' => 'App\\Http\\Controllers\\Frontend\\{ModuleName}Controller'
        ];
    }
}
