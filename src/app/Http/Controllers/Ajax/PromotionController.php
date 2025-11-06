<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Services\CustomerCatalougeService;
use App\Services\UserService;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    private $userService;
    private $customerCatalougeService;
    public function __construct(UserService $userService, CustomerCatalougeService $customerCatalougeService)
    {
        $this->userService = $userService;
        $this->customerCatalougeService = $customerCatalougeService;
    }
    public function loadCustomerPromotionType(Request $request)
    {
        $type = $request->input('type');
        $data = [];
        switch ($type) {
            case 'gender':
                $data = __('module.customer_type')['gender'];
                break;
            case 'birthday':
                $data = __('module.customer_type')['birthday'];
                break;
            case 'staff':
                $data = (array) $this->userService->getAll()->toArray();
                break;
            case 'cusomer_catalouge':
                $data = (array) $this->customerCatalougeService->getAll()->toArray();
                break;
            default:
                break;
        }

        $this->sendResponse($data);
    }
}
