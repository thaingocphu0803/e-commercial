<?php

namespace App\Repositories;

use App\Enums\PromotionEnum;
use App\Models\Promotion;
use App\Repositories\Interfaces\PromotionRepositoryInterface;

class PromotionRepository implements PromotionRepositoryInterface
{
    public function findById($id)
    {
        return Promotion::findOrFail($id);
    }

    public function findPivotById($id){
        return Promotion::with([
            'languages',
            'productCatalouges',
            'productVariants' => function ($q) {
                $q->with(['attrs' => function ($q) {
                    $q->with(['attrLanguage']);
                }]);
            }
        ])->findOrFail($id);
    }


    public function paginate($request)
    {
        $perpage = $request->input('perpage') ?? 10;
        $keyword = $request->input('keyword');
        $publish = $request->input('publish');

        return  Promotion::keyword($keyword ?? null)
            ->publish($publish ?? null)
            ->distinct()
            ->paginate($perpage)
            ->withQueryString();
    }

    public function create($payload)
    {
        return Promotion::create($payload);
    }

    public function SyncRelationPivot($model, $payload = []){
        if($payload[0]['model'] == PromotionEnum::MODEL_PRODUCT_CATALOUGE){
            return  $model->productCatalouges()->sync($payload);
        }elseif ($payload[0]['model'] == PromotionEnum::MODEL_PRODUCT){
            return  $model->products()->sync($payload);
        }
    }

    public function update($id, $payload)
    {
        return Promotion::find($id)->update($payload);
    }

    public function destroy($id)
    {
        return Promotion::destroy($id);
    }


    public function forceDestroy($id)
    {
        return Promotion::forceDestroy($id);
    }

    public function updateStatus($payload)
    {
        $modelId = $payload['modelId'];
        $value = $payload['value'] == 1 ? 2 : 1;
        $columm = [$payload['field'] => $value];

        return Promotion::find($modelId)->update($columm);
    }


    public function updateStatusAll($payload)
    {
        $ids = $payload['ids'];
        $value = $payload['value'];
        $columm = [$payload['field'] => $value];

        return Promotion::whereIn('id', $ids)->update($columm);
    }
}
