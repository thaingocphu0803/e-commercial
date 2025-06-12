<?php

namespace App\Repositories;

use App\Models\Menu;
use App\Models\User;
use App\Repositories\Interfaces\MenuRepositoryInterface;
use Illuminate\Support\Collection;


class MenuRepository implements MenuRepositoryInterface
{
    public function paginate($request)
    {
        $perpage = $request->input('perpage') ?? 10;
        $keywork = $request->input('keyword');
        $publish = $request->input('publish');
        $userCatalougeId = $request->input('user_catalouge_id');

        $query = User::with(
            'province',
            'district',
            'ward',
            'userCatalouge'
        )
            ->keyword($keywork ?? null)
            ->publish($publish ?? null);


        if ((!empty($userCatalougeId))) {
            $query->where('user_catalouge_id', $userCatalougeId);
        }


        return $query->orderBy('id', 'desc')->paginate($perpage)->withQueryString();
    }

    public function create($payload, $parent_id = null)
    {
        $parent = Menu::find($parent_id);
        if (!empty($parent)) {
            return $parent->children()->create($payload);
        } else {
            return Menu::create($payload);
        }
    }

    public function CreatePivotLanguage($model, $languageId, $payload)
    {
        $model->languages()->detach([$model->id, $languageId]);
        return $model->languages()->attach($model->id, $payload);
    }

    public function update($id, $payload)
    {
       $result =  Menu::find($id)->update($payload);

       if($result){
            return Menu::findOrFail($id);
       }

       return false;
    }

    public function updateStatus($payload)
    {
        $modelId = $payload['modelId'];
        $value = $payload['value'] == 1 ? 2 : 1;
        $columm = [$payload['field'] => $value];

        return Menu::find($modelId)->update($columm);
    }

    public function updateStatusAll($payload)
    {
        $ids = $payload['ids'];
        $value = $payload['value'];
        $columm = [$payload['field'] => $value];

        return Menu::whereIn('id', $ids)->update($columm);
    }

    public function toTreeById($id) : Collection
    {
        return Menu::with('menuLanguage')->where('menu_catalouge_id', $id)->orderBy('order')->get()->toTree();
    }

    public function reBuildTree($newTree)
    {
        $this->updateNodeOrder($newTree);
        return Menu::rebuildTree($newTree);
    }

    public function updateNodeOrder($newTree){
        foreach($newTree as $key=>$val){
            $payload['order'] = $key;
            $this->update($val['id'], $payload);
            if(isset($val['children']) && count($val['children'])){
                $this->updateNodeOrder($val['children']);
            }
        }
    }
}
