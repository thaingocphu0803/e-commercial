<?php

namespace App\Repositories\Interfaces;

/**
 * Interface SourceRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface SourceRepositoryInterface
{
    public function getAll();

    public function findById($id);

    public function paginate($request);

    public function create($payload);

    public function update($id, $payload);

    public function destroy($id);

    public function forceDestroy($id);

    public function updateStatus($payload);

    public function updateStatusAll($payload);
}
