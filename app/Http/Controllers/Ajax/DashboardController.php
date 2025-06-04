<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Laravel\Pail\ValueObjects\Origin\Console;

class DashboardController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService =  $userService;
    }

    public function changeStatus(Request $request)
    {
        $payload = $request->except('_token');

        $serviceNameSpace = '\App\Services\\' . ucfirst($payload['model']) . 'Service';

        $serviceInstance = app($serviceNameSpace);

        $flag = $serviceInstance->updateStatus($payload);

        return response()->json([
            'flag' => $flag
        ]);
    }

    public function changeStatusAll(Request $request)
    {
        $payload = $request->except('_token');

        $serviceNameSpace = '\App\Services\\' . ucfirst($payload['model']) . 'Service';

        $serviceInstance = app($serviceNameSpace);

        $flag = $serviceInstance->updateStatusAll($payload);

        return response()->json([
            'flag' => $flag
        ]);
    }

    public function uploadImage(Request $request)
    {
        $uploadedFile = $request->file('file');
        $response = cloudinary()->upload($uploadedFile->getRealPath());


        return response()->json([
            'location' => $response->getSecurePath()
        ]);
    }

    public function getMenu(Request $request)
    {
        $model = ucfirst($request->input('model'));
        $serviceNamespace = "App\\Services\\" . $model . "Service";
        if (class_exists($serviceNamespace)) {
            $serviceInstance = app($serviceNamespace);
        }

        $modelMenu  = $serviceInstance->paginate($request);
        if ($modelMenu) {

            return response()->json([
                'code' => 0,
                'status' => 'ok',
                'data' => $modelMenu,
            ]);
        } else {
            return response()->json([
                'code' => 1,
                'status' => 'ng',
            ]);
        }
    }
}
