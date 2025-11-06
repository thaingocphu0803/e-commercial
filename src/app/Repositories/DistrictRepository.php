<?php

namespace App\Repositories;

use App\Models\District;
use App\Repositories\Interfaces\DistrictRepositoryInterface;

class DistrictRepository implements DistrictRepositoryInterface {
    public function getAll()
    {
        return District::all();
    }

    public function findDistrictByProvinceId($province_id){
        return District::where('province_code',  $province_id)->get();
    }
}
