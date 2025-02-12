<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Repositories\DistrictRepository;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    protected $districtRepository;

    public function __construct(DistrictRepository $districtRepository)
    {
        $this->districtRepository = $districtRepository;
    }

    public function district(Request $request){
        $province_id = $request->input('province_id');

        $result = $this->districtRepository->findDistrictByProvinceId($province_id);

        return response()->json($result);
    }
}
