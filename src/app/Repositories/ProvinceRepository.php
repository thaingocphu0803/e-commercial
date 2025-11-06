<?php

namespace App\Repositories;

use App\Models\Province;
use App\Repositories\Interfaces\ProvinceRepositoryInterface;

class ProvinceRepository implements ProvinceRepositoryInterface {
    public function getAll()
    {
        return Province::all();
    }
}
