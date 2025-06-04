<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveChildMenuRequest;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Models\Language;
use App\Models\Menu;
use App\Services\MenuCatalougeService;
use App\Services\MenuService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MenuController extends Controller
{
    protected $menuService;
    protected $menuCatalougeService;
    protected $languageId;

    public function __construct(
        MenuService $menuService,
        MenuCatalougeService $menuCatalougeService
    ) {
        $this->menuService = $menuService;
        $this->menuCatalougeService = $menuCatalougeService;

        $locale = app()->getLocale();
        $language = Language::where('canonical', $locale)->first();
        $this->languageId = $language->id;
    }

    public function index(Request $request)
    {
        Gate::authorize('modules', 'menu.index');
        $menuCatalouges = $this->menuCatalougeService->paginate($request);
        return view('Backend.menu.menu.index', compact('menuCatalouges'));
    }

    public function create()
    {
        Gate::authorize('modules', 'menu.create');
        $menuCatalouges = $this->menuCatalougeService->getAll();
        return view('Backend.menu.menu.create', compact('menuCatalouges'));
    }

    public function store(StoreMenuRequest $request)
    {
        Gate::authorize('modules', 'menu.create');

        if ($this->menuService->create($request, $this->languageId)) {
            return redirect()->route('menu.index')->with('success', __('alert.addSuccess', ['attribute' => __('custom.menu')]));
        }

        return redirect()->route('menu.index')->with('error', __('alert.addError', ['attribute' => __('custom.menu')]));
    }

    public function edit($id)
    {
        Gate::authorize('modules', 'menu.update');
        $menuCatalouge = $this->menuCatalougeService->findById($id);
        if (!$menuCatalouge) {
            abort(404, __('alert.menuCatalougeNotFound'));
        }

        $menus = $menuCatalouge->menus->pluck('menuLanguage.name', 'id')->toArray();

        return view('backend.menu.menu.list', compact('menus'));
    }

    public function update($id, UpdateMenuRequest $request)
    {
        Gate::authorize('modules', 'menu.update');
        if ($this->menuService->update($id, $request)) {
            return redirect()->route('menu.index')->with('success', __('alert.updateSuccess', ['attribute' => __('custom.menu')]));
        }

        return redirect()->route('menu.index')->with('error', __('alert.updateError', ['attribute' => __('custom.menu')]));
    }

    public function delete(Menu $menu)
    {
        Gate::authorize('modules', 'menu.delete');
        return view('backend.menu.menu.delete', [
            'menu' => $menu
        ]);
    }

    public function destroy($id)
    {
        Gate::authorize('modules', 'menu.delete');
        if ($this->menuService->destroy($id)) {
            return redirect()->route('menu.index')->with('success', __('alert.deleteSuccess', ['attribute' => __('custom.menu')]));
        }

        return redirect()->route('menu.index')->with('error', __('alert.deleteError', ['attribute' => __('custom.menu')]));
    }

    public function childIndex($id)
    {
        $parentId = $id;
        $menus = Menu::with('menuLanguage')->where('parent_id', $id)->get();
        $parent_menu_catalouge_id = Menu::find($id)->menu_catalouge_id;

        $menuArr = [
            'name' => $menus->pluck('menuLanguage.name')->toArray(),
            'canonical' => $menus->pluck('menuLanguage.canonical')->toArray(),
            'position' => $menus->pluck('order')->toArray(),
            'id' => $menus->pluck('id')->toArray(),
        ];

        Gate::authorize('modules', 'menu.create');
        return view('Backend.menu.menu.child', compact('parentId', 'menuArr', 'parent_menu_catalouge_id'));
    }

    public function childSave(SaveChildMenuRequest $request, $parent_id)
    {
        Gate::authorize('modules', 'menu.create');

        $parentMenu = Menu::find($parent_id);

        $parent_menu_catalouge_id = $parentMenu->menu_catalouge_id;
        if ($this->menuService->childSave($request, $parent_id, $parent_menu_catalouge_id, $this->languageId)) {
            return redirect()->route('menu.child.index', $parent_id)->with('success', __('alert.saveSuccess', ['attribute' => __('custom.childMenu')]));
        }
        return redirect()->route('menu.child.index', $parent_id)->with('error', __('alert.saveError', ['attribute' => __('custom.childMenu')]));
    }
}
