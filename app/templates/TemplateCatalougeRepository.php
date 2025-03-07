<?php

namespace App\Repositories;

use App\Models\{ModuleName};
use App\Models\{ModuleName}Language;
use App\Repositories\Interfaces\{ModuleName}RepositoryInterface;

class {ModuleName}Repository implements {ModuleName}RepositoryInterface
{
    public function getAll()
    {
        return {ModuleName}::select('name', 'id')
            ->where('publish', 1)
            ->get();
    }

    public function getToTree($id = null)
    {
        ${moduleName}s = {ModuleName}::with('languages')->where('id', '!=', $id)->orderBy('_lft', 'asc')->get();

        ${moduleName}s = ${moduleName}s->map(function (${moduleName}) {
            if (${moduleName}->languages->isNotEmpty()) {
                ${moduleName}['name'] = ${moduleName}->languages->first()->pivot->name;
            }
            return ${moduleName};
        });

        return ${moduleName}s->toTree();
    }

    public function findById($id)
    {
        ${moduleName} = {ModuleName}::with('languages')->findOrFail($id);
        if (${moduleName}->languages->isEmpty()) {
            return false;
        }

        $pivot = ${moduleName}->languages->first()->pivot;
        $pivot['parent_id'] = ${moduleName}->parent_id;
        $pivot['publish'] = ${moduleName}->publish;
        $pivot['follow'] = ${moduleName}->follow;
        $pivot['image'] = ${moduleName}->image;
        $pivot['album'] = ${moduleName}->album;


        return  $pivot;
    }


    public function paginate($request)
    {
        $perpage = $request->input('perpage') ?? 10;
        $keyword = $request->input('keyword');
        $publish = $request->input('publish');

        $query =  {ModuleName}::select(
            '{moduleTableName}s.id as id',
            '{moduleTableName}s.image as image',
            'pcl.name as name',
            'pcl.canonical as canonical',
            '{moduleTableName}s.publish as publish'
        )
        ->join('{moduleTableName}_language as pcl', 'pcl.{moduleTableName}_id', '=', '{moduleTableName}s.id')
        ->keyword($keyword ?? null)
        ->publish($publish ?? null);

        return $query->orderBy('{moduleTableName}s._lft')->paginate($perpage)->withQueryString();
    }

    public function create($payload)
    {
        $parent = {ModuleName}::find($payload['parent_id']);

        if (!empty($parent)) {
            return $parent->children()->create($payload);
        } else {
            return {ModuleName}::create($payload);
        }
    }

    public function createPivot($model, $payload = [])
    {
        return $model->languages()->attach($model->id, $payload);
    }

    public function update($id, $payload)
    {
        return {ModuleName}::find($id)->update($payload);
    }

    public function UpdatePivot($id, $payload = [])
    {
        return {ModuleName}Language::where('{moduleTableName}_id', $id)
            ->update($payload);
    }

    public function destroy($id)
    {
        $node = {ModuleName}::findOrFail($id);
        $left = $node->_lft;
        $right = $node->_rgt;
        $width = $right - $left + 1;

        $deteted = {ModuleName}::destroy($id);

        if ($deteted) {
            {ModuleName}::where('_lft', '>', $right)->decrement('_lft', $width);
            {ModuleName}::where('_rgt', '>', $right)->decrement('_rgt', $width);

            return true;
        }

        return false;
    }


    public function forceDestroy($id)
    {
        return {ModuleName}::forceDestroy($id);
    }

    public function updateStatus($payload)
    {
        $modelId = $payload['modelId'];
        $value = $payload['value'] == 1 ? 2 : 1;
        $columm = [$payload['field'] => $value];

        return {ModuleName}::find($modelId)->update($columm);
    }


    public function updateStatusAll($payload)
    {
        $ids = $payload['ids'];
        $value = $payload['value'];
        $columm = [$payload['field'] => $value];

        return {ModuleName}::whereIn('id', $ids)->update($columm);
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
