<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMenuCatalougeRequest;
use App\Services\MenuCatalougeService;

class MenuController extends Controller
{
    protected $menuCatalougeService;

    public function __construct(MenuCatalougeService $menuCatalougeService)
    {
        $this->menuCatalougeService = $menuCatalougeService;
    }

    public function createCatalouge(StoreMenuCatalougeRequest $request)
    {
        $menuCatalouge = $this->menuCatalougeService->create($request);

        if ($menuCatalouge) {
            return response()->json([
                'code' => 0,
                'status' => 'ok',
                'data' => [
                    'name' => $menuCatalouge->name,
                    'id' => $menuCatalouge->id,
                ]
            ]);
        } else {
            return response()->json([
                'code' => 1,
                'status' => 'ng',
                'data' => []
            ]);
        }
    }
}
