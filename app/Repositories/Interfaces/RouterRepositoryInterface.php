<?php

namespace App\Repositories\Interfaces;

/**
 * Interface RouterRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface RouterRepositoryInterface
{
    public function create($router);

    public function update($router);
}
