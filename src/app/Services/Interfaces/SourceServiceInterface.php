<?php

namespace App\Services\Interfaces;

/**
 * Interface SourceServiceInterface
 * @package App\Services\Interfaces
 */
interface SourceServiceInterface
{
    public function getAll();

    public function findById($id);

    public function paginate($number);

    public function create($request);

    public function update($id, $request);

    public function destroy($id);

    public function forceDestroy($id);

    public function updateStatus($payload);

    public function updateStatusAll($payload);

}
