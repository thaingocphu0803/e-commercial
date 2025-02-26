<?php

namespace App\Repositories\Interfaces;

/**
 * Interface PostCatalougeRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface PostCatalougeRepositoryInterface
{
    public function getAll();

    public function getToTree($id = null);

    public function findById($id);

    public function paginate($request);

    public function create($payload);

    public function update($id, $payload);

    public function destroy($id);

    public function forceDestroy($id);

    public function updateStatus($payload);

    public function updateStatusAll($payload);

    public function createPivot($model, $payload = []);

    public function updatePivot($model, $payload = []);


    // public function updateByWhereIn($ids, $value);

}
