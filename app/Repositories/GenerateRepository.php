<?php

namespace App\Repositories;

use App\Models\Generate;
use App\Repositories\Interfaces\GenerateRepositoryInterface;

class GenerateRepository implements GenerateRepositoryInterface
{
    public function getAll()
    {
        return Generate::select('name', 'id')
            ->where('publish', 1)
            ->get();
    }

    public function paginate($request)
    {
        $perpage = $request->input('perpage') ?? 10;
        $keywork = $request->input('keyword');
        $publish = $request->input('publish');

        return  Generate::keyword($keywork ?? null)
            ->publish($publish ?? null)
            ->orderBy('id', 'desc')
            ->paginate($perpage)
            ->withQueryString();
    }

    public function create($payload)
    {
        return Generate::create($payload);
    }

    public function update($id, $payload)
    {
        return Generate::find($id)->update($payload);
    }

    public function destroy($id)
    {
        return Generate::destroy($id);
    }


    public function forceDestroy($id)
    {
        return Generate::forceDestroy($id);
    }

    public function updateStatus($payload)
    {
        $modelId = $payload['modelId'];
        $value = $payload['value'] == 1 ? 2 : 1;
        $columm = [$payload['field'] => $value];

        return Generate::find($modelId)->update($columm);
    }


    public function updateStatusAll($payload)
    {
        $ids = $payload['ids'];
        $value = $payload['value'];
        $columm = [$payload['field'] => $value];

        return Generate::whereIn('id', $ids)->update($columm);
    }

    public function changeCurrent($canonical)
    {
        return Generate::query()->update([
            'current' => Generate::raw("IF(canonical = '$canonical', 1, 0)")
        ]);

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
