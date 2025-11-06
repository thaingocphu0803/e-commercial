<?php

namespace App\Repositories;
use App\Models\Source;
use App\Repositories\Interfaces\SourceRepositoryInterface;

class SourceRepository implements SourceRepositoryInterface
{
    public function getAll()
    {
        return Source::where('publish', 1)
            ->get();
    }

    public function findById($id)
    {
        $source = Source::findOrFail($id);
        return  $source;
    }

    public function paginate($request)
    {
        $perpage = $request->input('perpage') ?? 10;
        $keyword = $request->input('keyword');
        $publish = $request->input('publish');

        $query =  Source::keyword($keyword ?? null)
        ->publish($publish ?? null);
        return $query->distinct()->paginate($perpage)->withQueryString();
    }

    public function create($payload)
    {
        return Source::create($payload);
    }

    public function update($id, $payload)
    {
        return Source::find($id)->update($payload);
    }

    public function destroy($id)
    {
        return Source::destroy($id);
    }


    public function forceDestroy($id)
    {
        return Source::forceDestroy($id);
    }

    public function updateStatus($payload)
    {
        $modelId = $payload['modelId'];
        $value = $payload['value'] == 1 ? 2 : 1;
        $columm = [$payload['field'] => $value];
        return Source::find($modelId)->update($columm);
    }


    public function updateStatusAll($payload)
    {
        $ids = $payload['ids'];
        $value = $payload['value'];
        $columm = [$payload['field'] => $value];

        return Source::whereIn('id', $ids)->update($columm);
    }
}
