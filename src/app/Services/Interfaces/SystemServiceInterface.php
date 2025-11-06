<?php

namespace App\Services\Interfaces;

/**
 * Interface SystemServiceInterface
 * @package App\Services\Interfaces
 */
interface SystemServiceInterface
{
    public function create($request, $language_id);

    public function all();
}
