<?php

namespace App\Services\Interfaces;

/**
 * Interface AttrCatalougeServiceInterface
 * @package App\Services\Interfaces
 */
interface AttrCatalougeServiceInterface
{
    public function getAll();

    public function getToTree($id = null);

    public function findById($id);

    public function paginate($number);

    public function create($request);

    public function update($id, $request);

    public function destroy($id);

    public function forceDestroy($id);

    public function updateStatus($payload);

    public function updateStatusAll($payload);

}
