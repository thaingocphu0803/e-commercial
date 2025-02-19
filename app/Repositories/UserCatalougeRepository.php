<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserCatalouge;
use App\Repositories\Interfaces\UserCatalougeRepositoryInterface;

class UserCatalougeRepository implements UserCatalougeRepositoryInterface
{
    public function getAll()
    {
        return UserCatalouge::select('name', 'id')
            ->where('publish', 1)
            ->get();
    }

    public function paginate($request)
    {
        $perpage = $request->input('perpage') ?? 10;
        $keywork = $request->input('keyword');
        $publish = $request->input('publish');

        $query =  UserCatalouge::withCount('users')->where('name', 'like', '%' . $keywork . '%');


        if (!empty($publish)) {
            $query->where('publish', $publish);
        }

        return $query->orderBy('id', 'desc')->paginate($perpage)->withQueryString();
    }

    public function create($payload)
    {
        return UserCatalouge::create($payload);
    }

    public function update($id, $payload)
    {
        return UserCatalouge::find($id)->update($payload);
    }

    public function destroy($id)
    {
        return UserCatalouge::destroy($id);
    }


    public function forceDestroy($id)
    {
        return UserCatalouge::forceDestroy($id);
    }

    public function updateStatus($payload)
    {
        $modelId = $payload['modelId'];
        $value = $payload['value'] == 1 ? 2 : 1;
        $columm = [$payload['field'] => $value];

        return UserCatalouge::find($modelId)->update($columm);
    }


    public function updateStatusAll($payload)
    {
        $ids = $payload['ids'];
        $value = $payload['value'];
        $columm = [$payload['field'] => $value];

        return UserCatalouge::whereIn('id', $ids)->update($columm);
    }

    public function updateByWhereIn($ids, $value)
    {

        if (is_array($ids)) {
            return User::whereIn('user_catalouge_id', $ids)
                ->update(['publish' => $value]);
        } else {
            $value = $value == 1 ? 2 : 1;
            return User::where('user_catalouge_id', $ids)
                ->update(['publish' => $value]);
        }
    }
}
