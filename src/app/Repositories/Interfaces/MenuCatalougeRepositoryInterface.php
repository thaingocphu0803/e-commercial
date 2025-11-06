<?php

namespace App\Repositories\Interfaces;

/**
 * Interface MenuCatalougeRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface MenuCatalougeRepositoryInterface
{
    public function paginate($request);

    public function create($payload);

    public function getAll();

    public function findById($id);

    public function toTreeByKeyword($keyword);

    public function forceDestroy($id);

    public function updateStatus($payload);

    public function updateStatusAll($payload);

}
