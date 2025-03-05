<?php

namespace App\Repositories\Interfaces;

/**
 * Interface PermissionRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface PermissionRepositoryInterface
{
    public function getAll();

    public function paginate($request);

    public function create($payload);

    public function update($id, $payload);

    public function destroy($id);

    public function updateStatus($payload);

    public function updateStatusAll($payload);

    // public function updateByWhereIn($ids, $value);

}
