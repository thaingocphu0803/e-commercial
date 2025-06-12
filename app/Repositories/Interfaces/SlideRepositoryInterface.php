<?php

namespace App\Repositories\Interfaces;

/**
 * Interface SlideRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface SlideRepositoryInterface
{
    public function paginate($request);

    public function create($payload);

    public function update($id, $payload);

    public function destroy($id);

    public function forceDestroy($id);

    public function updateStatus($payload);

    public function updateStatusAll($payload);

}
