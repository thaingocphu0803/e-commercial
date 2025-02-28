<?php

namespace App\Repositories;

use App\Models\Language;
use App\Repositories\Interfaces\LanguageRepositoryInterface;

class LanguageRepository implements LanguageRepositoryInterface
{
    public function getAll()
    {
        return Language::select('name', 'id')
            ->where('publish', 1)
            ->get();
    }

    public function paginate($request)
    {
        $perpage = $request->input('perpage') ?? 10;
        $keywork = $request->input('keyword');
        $publish = $request->input('publish');

        return  Language::keyword($keywork ?? null)
        ->publish($publish ?? null)
        ->orderBy('id', 'desc')
        ->paginate($perpage)
        ->withQueryString();
    }

    public function create($payload)
    {
        return Language::create($payload);
    }

    public function update($id, $payload)
    {
        return Language::find($id)->update($payload);
    }

    public function destroy($id)
    {
        return Language::destroy($id);
    }


    public function forceDestroy($id)
    {
        return Language::forceDestroy($id);
    }

    public function updateStatus($payload)
    {
        $modelId = $payload['modelId'];
        $value = $payload['value'] == 1 ? 2 : 1;
        $columm = [$payload['field'] => $value];

        return Language::find($modelId)->update($columm);
    }


    public function updateStatusAll($payload)
    {
        $ids = $payload['ids'];
        $value = $payload['value'];
        $columm = [$payload['field'] => $value];

        return Language::whereIn('id', $ids)->update($columm);
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
