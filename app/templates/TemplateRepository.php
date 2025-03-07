<?php

namespace App\Repositories;

use App\Models\{ModuleName};
use App\Models\{ModuleName}Catalouge;
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

    public function getToTree()
    {
        ${moduleName}Catalouges = {ModuleName}Catalouge::with('languages')->orderBy('_lft', 'asc')->get();

        ${moduleName}Catalouges = ${moduleName}Catalouges->map(function (${moduleName}) {
            if (${moduleName}->languages->isNotEmpty()) {
                ${moduleName}['name'] = ${moduleName}->languages->first()->pivot->name;
            }
            return ${moduleName};
        });

        return ${moduleName}Catalouges->toTree();
    }

    public function findById($id)
    {
        ${moduleName} = {ModuleName}::with('languages', '{moduleName}Catalouges')->findOrFail($id);
        if (${moduleName}->languages->isEmpty()) {
            return false;
        }
        $pivot = ${moduleName}->languages->first()->pivot;
        $pivot['{moduleName}_catalouge_id'] = ${moduleName}->{moduleName}_catalouge_id;
        $pivot['publish'] = ${moduleName}->publish;
        $pivot['follow'] = ${moduleName}->follow;
        $pivot['image'] = ${moduleName}->image;
        $pivot['album'] = ${moduleName}->album;
        $pivot['catalouges'] = ${moduleName}->{moduleName}Catalouges
                                ->pluck('pivot.{moduleName}_catalouge_id')
                                ->toArray();
        return  $pivot;
    }


    public function paginate($request)
    {
        $perpage = $request->input('perpage') ?? 10;
        $keyword = $request->input('keyword');
        $publish = $request->input('publish');
        ${moduleName}_catalouge_id = $request->input('{moduleName}_catalouge_id');

        $query =  {ModuleName}::with('{moduleName}Catalouges.languages')->select(
            '{moduleName}s.id as id',
            '{moduleName}s.image as image',
            'pl.name as name',
            '{moduleName}s.publish as publish',
            '{moduleName}s.order as order'
        )
        ->join('{moduleName}_language as pl', 'pl.{moduleName}_id', '=', '{moduleName}s.id')
        ->join('{moduleName}_catalouge_{moduleName} as pcp', 'pcp.{moduleName}_id', '=', '{moduleName}s.id')
        ->keyword($keyword ?? null)
        ->publish($publish ?? null);

        if(!empty(${moduleName}_catalouge_id)){
            $catalouges = $this->getDescendantsAndSelf(${moduleName}_catalouge_id);
            if(!empty($catalouges)){
                $query->WhereIn('{moduleName}s.{moduleName}_catalouge_id', $catalouges);
            }
        }

        return $query->distinct()->paginate($perpage)->withQueryString();
    }

    public function getDescendantsAndSelf($id)
    {
        return {ModuleName}Catalouge::descendantsAndSelf($id)->pluck('id');
    }

    public function create($payload)
    {
            return {ModuleName}::create($payload);
    }

    public function createLanguagePivot($model, $payload = [])
    {
        return $model->languages()->attach($model->id, $payload);
    }

    public function createCatalougePivot($model, $payload = [])
    {
        return $model->{moduleName}Catalouges()->sync($payload);
    }

    public function updateCatalougePivot($id, $payload = [])
    {
        return {ModuleName}::find($id)->{moduleName}Catalouges()->sync($payload);
    }


    public function update($id, $payload)
    {
        return {ModuleName}::find($id)->update($payload);
    }

    public function update{ModuleName}Language($id, $payload = [])
    {
        return {ModuleName}Language::where('{moduleName}_id', $id)
            ->update($payload);
    }

    public function destroy($id)
    {
        return {ModuleName}::destroy($id);
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
