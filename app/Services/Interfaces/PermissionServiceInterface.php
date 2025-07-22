<?php

namespace App\Services\Interfaces;

/**
 * Interface PermissionServiceInterface
 * @package App\Services\Interfaces
 */
interface PermissionServiceInterface
{
    public function getAll();

    public function paginate($number);

    public function create($request);

    public function update($id, $request);

    public function destroy($id);

    public function updateStatus($payload);

    public function updateStatusAll($payload);

}
