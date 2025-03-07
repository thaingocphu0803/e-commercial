<?php

namespace App\Repositories\Interfaces;

/**
 * Interface GenerateRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface GenerateRepositoryInterface
{
    public function getAll();

    public function paginate($request);

    public function create($payload);

    public function update($id, $payload);

    public function destroy($id);

    public function forceDestroy($id);

    public function updateStatus($payload);

    public function updateStatusAll($payload);

    public function changeCurrent($canonical);

    // public function updateByWhereIn($ids, $value);

}
