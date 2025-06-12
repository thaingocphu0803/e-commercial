<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMenuCatalougeRequest;
use App\Services\MenuCatalougeService;
use App\Services\MenuService;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    protected $menuCatalougeService;
    protected $menuService;

    public function __construct(
        MenuCatalougeService $menuCatalougeService,
        MenuService $menuService
    )
    {
        $this->menuCatalougeService = $menuCatalougeService;
        $this->menuService = $menuService;
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

    public function dragDrop(Request $request)
    {
        $newTree = json_decode($request->input('json'), true);

        $result = $this->menuService->reBuildTree($newTree);

        if ($result) {
            return response()->json([
                'code' => 0,
                'status' => 'ok',
                'data' => []
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
