<?php

namespace App\Repositories\Interfaces;

/**
 * Interface CustomerRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface CustomerRepositoryInterface
{
    public function paginate($request);

    public function create($payload);

    public function update($id, $payload);

    public function destroy($id);

    public function forceDestroy($id);

    public function updateStatus($payload);

    public function updateStatusAll($payload);

}
