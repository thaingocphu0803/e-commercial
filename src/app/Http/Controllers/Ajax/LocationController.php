<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Repositories\DistrictRepository;
use App\Repositories\WardRepository;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    protected $districtRepository;
    protected $wardRepository;

    public function __construct(
        DistrictRepository $districtRepository,
        WardRepository $wardRepository
        )
    {
        $this->districtRepository = $districtRepository;
        $this->wardRepository = $wardRepository;
    }

    public function district(Request $request){
        $province_id = $request->input('province_id');

        $result = $this->districtRepository->findDistrictByProvinceId($province_id);

        return response()->json($result);
    }

    public function ward(Request $request){
        $district_id = $request->input('district_id');

        $result = $this->wardRepository->findWardByDistrictId($district_id);

        return response()->json($result);
    }
}
