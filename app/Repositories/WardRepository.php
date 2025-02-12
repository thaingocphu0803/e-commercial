<?php

namespace App\Repositories;

use App\Models\Ward;
use App\Repositories\Interfaces\WardRepositoryInterface;

class WardRepository implements WardRepositoryInterface {
    public function getAll()
    {
        return Ward::all();
    }
}
