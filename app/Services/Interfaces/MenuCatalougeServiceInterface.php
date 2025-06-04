<?php

namespace App\Services\Interfaces;

/**
 * Interface MenuCatalougeServiceInterface
 * @package App\Services\Interfaces
 */
interface MenuCatalougeServiceInterface
{
    public function paginate($request);

    public function create($request);

    public function getAll();

    public function findById($id);

    // public function update($id, $request);

    // public function destroy($id);

    // public function forceDestroy($id);

    public function updateStatus($payload);

    public function updateStatusAll($payload);

}
