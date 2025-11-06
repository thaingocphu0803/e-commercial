<?php

namespace App\Repositories\Interfaces;

/**
 * Interface SystemRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface SystemRepositoryInterface
{
    public function updateOrInsert($payload, $condition);

    public function getAll();
}
