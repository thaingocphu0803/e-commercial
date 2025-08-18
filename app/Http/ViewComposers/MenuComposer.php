<?php

namespace App\Http\ViewComposers;

use App\Services\MenuCatalougeService;
use Illuminate\View\View;

class MenuComposer
{
    /**
     * Create a new class instance.
     */
    private $menuCatalougeService;

    public function __construct(MenuCatalougeService $menuCatalougeService)
    {
        $this->menuCatalougeService = $menuCatalougeService;
    }

    public function compose(View $view){
        $menus = $this->menuCatalougeService->toTreeByKeyword('main-menu');
        $topMenus = $this->menuCatalougeService->toTreeByKeyword('top-menu');
        $view->with(compact('menus', 'topMenus'));
    }
}
