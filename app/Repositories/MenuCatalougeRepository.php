<?php

namespace App\Repositories;

use App\Models\MenuCatalouge;
use App\Repositories\Interfaces\MenuCatalougeRepositoryInterface;

class MenuCatalougeRepository implements MenuCatalougeRepositoryInterface {
    public function paginate($request)
    {
        $perpage = $request->input('perpage') ?? 10;
        $keywork = $request->input('keyword');
        $publish = $request->input('publish');

        $query = MenuCatalouge::select(
            'id',
            'publish',
            'name',
            'keyword',
        )
        ->keyword($keywork ?? null)
        ->publish($publish ?? null);

        return $query ->orderBy('id', 'desc')->paginate($perpage)->withQueryString();
    }

    public function getAll(){
        return MenuCatalouge::all();
    }

    public function findById($id)
    {
        return MenuCatalouge::with('menus.menuLanguage')->findOrFail($id);
    }

    public function create($payload){

        return MenuCatalouge::create($payload);
    }

    public function forceDestroy($id)
    {
        return MenuCatalouge::forceDestroy($id);
    }

    public function updateStatus($payload)
    {
        $modelId = $payload['modelId'];
        $value = $payload['value'] == 1 ? 2 : 1;
        $columm = [ $payload['field'] => $value];

        return MenuCatalouge::find($modelId)->update($columm);
    }


    public function updateStatusAll($payload)
    {
        $ids = $payload['ids'];
        $value = $payload['value'];
        $columm = [ $payload['field'] => $value];

        return MenuCatalouge::whereIn('id', $ids)->update($columm);
    }
}
