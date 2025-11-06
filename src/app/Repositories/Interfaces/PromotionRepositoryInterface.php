<?php

namespace App\Repositories\Interfaces;

/**
 * Interface PromotionRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface PromotionRepositoryInterface
{
    public function findById($id);

    public function paginate($request);

    public function create($payload);

    public function SyncRelationPivot($model, $payload = []);

    public function update($id, $payload);

    public function destroy($id);

    public function forceDestroy($id);

    public function updateStatus($payload);

    public function updateStatusAll($payload);

    public function findPivotById($id);

    public function getAllPromotionByCartTotal();

}
