<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $userService;
    public function __construct( UserService $userService)
    {
        $this->userService =  $userService;
    }

    public function changeStatus(Request $request){



        $payload = $request->except('_token');

        $serviceNameSpace = '\App\Services\\'.ucfirst($payload['model']).'Service';

        $serviceInstance = app($serviceNameSpace);

        $flag = $serviceInstance->updateStatus($payload);

        return response()->json([
            'flag' => $flag
        ]);
    }

    public function changeStatusAll(Request $request){
        $payload = $request->except('_token');

        $serviceNameSpace = '\App\Services\\'.ucfirst($payload['model']).'Service';

        $serviceInstance = app($serviceNameSpace);

        $flag = $serviceInstance->updateStatusAll($payload);

        return response()->json([
            'flag' => $flag
        ]);

    }
}
