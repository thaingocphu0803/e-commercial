<?php

namespace App\Repositories\Interfaces;

/**
 * Interface PostRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface PostRepositoryInterface
{
    public function getAll();

    public function getToTree();

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
