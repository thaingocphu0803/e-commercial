<?php

namespace App\Repositories;

use App\Models\Ward;
use App\Repositories\Interfaces\WardRepositoryInterface;

class WardRepository implements WardRepositoryInterface {
    public function getAll()
    {
        return Ward::all();
    }

    public function findWardByDistrictId($district_id){
        return Ward::where('district_code', $district_id)->get();
    }
}
