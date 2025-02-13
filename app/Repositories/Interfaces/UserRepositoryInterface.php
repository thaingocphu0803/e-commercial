<?php

namespace App\Repositories\Interfaces;

/**
 * Interface UserRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface UserRepositoryInterface
{
    public function getPaginate($number);

    public function create($payload);

    public function update($id, $payload);
}
