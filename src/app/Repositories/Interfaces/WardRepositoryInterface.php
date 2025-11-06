<?php

namespace App\Repositories\Interfaces;

/**
 * Interface WardRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface WardRepositoryInterface
{
    public function getAll();

    public function findWardByDistrictId($district_id);
}
