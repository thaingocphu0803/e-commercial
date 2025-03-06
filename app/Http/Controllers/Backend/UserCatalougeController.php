<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserCatalougeRequest;
use App\Http\Requests\UpdateUserCatalougeRequest;
use App\Models\UserCatalouge;
use App\Services\PermissionService;
use App\Services\UserCatalougeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserCatalougeController extends Controller
{
    protected $userCatalougeService;
    protected $permissionService;

    public function __construct(
        UserCatalougeService $userCatalougeService,
        PermissionService $permissionService
    ) {
        $this->userCatalougeService = $userCatalougeService;
        $this->permissionService = $permissionService;
    }

    public function index(Request $request)
    {
        Gate::authorize('modules', 'user.catalouge.index');
        $userCatalouges = $this->userCatalougeService->paginate($request);
        return view('Backend.user.catalouge.index', [
            'userCatalouges' => $userCatalouges
        ]);
    }

    public function create()
    {
        Gate::authorize('modules', 'user.catalouge.create');
        return view('Backend.user.catalouge.create');
    }

    public function store(StoreUserCatalougeRequest $request)
    {
        Gate::authorize('modules', 'user.catalouge.create');
        if ($this->userCatalougeService->create($request)) {
            return redirect()->route('user.catalouge.index')->with('success', __('alert.addSuccess', ['attribute' => __('dashboard.memberGroup')]));
        }
        return redirect()->route('user.catalouge.index')->with('error', __('alert.addError', ['attribute' => __('dashboard.memberGroup')]));
    }

    public function edit(UserCatalouge $userCatalouge)
    {
        Gate::authorize('modules', 'user.catalouge.update');
        return view('backend.user.catalouge.create', [
            'userCatalouge' => $userCatalouge
        ]);
    }

    public function update($id, UpdateUserCatalougeRequest $request)
    {
        Gate::authorize('modules', 'user.catalouge.update');
        if ($this->userCatalougeService->update($id, $request)) {
            return redirect()->route('user.catalouge.index')->with('success', __('alert.updateSuccess', ['attribute' => __('dashboard.memberGroup')]));
        }

        return redirect()->route('user.catalouge.index')->with('error', __('alert.updateError', ['attribute' => __('dashboard.memberGroup')]));
    }

    public function delete(UserCatalouge $userCatalouge)
    {
        Gate::authorize('modules', 'user.catalouge.delete');
        return view('backend.user.catalouge.delete', [
            'userCatalouge' => $userCatalouge
        ]);
    }

    public function destroy($id)
    {
        Gate::authorize('modules', 'user.catalouge.delete');
        if ($this->userCatalougeService->destroy($id)) {
            return redirect()->route('user.catalouge.index')->with('success', __('alert.deleteSuccess', ['attribute' => __('dashboard.memberGroup')]));
        }

        return redirect()->route('user.catalouge.index')->with('error', __('alert.deleteError', ['attribute' => __('dashboard.memberGroup')]));
    }

    public function permission()
    {
        Gate::authorize('modules', 'user.catalouge.permission');
        $userCatalouges = $this->userCatalougeService->getAll();
        $permissions = $this->permissionService->getAll();

        return view('Backend.user.catalouge.permission', [
            'userCatalouges' => $userCatalouges,
            'permissions' => $permissions
        ]);
    }

    public function updatePermission(Request $request)
    {
        Gate::authorize('modules', 'user.catalouge.permission');
        // dd($this->userCatalougeService->setPermission($request));
        if ($this->userCatalougeService->setPermission($request)) {
            return redirect()->route('user.catalouge.index')->with('success', __('alert.permitSuccess'));
        }

        return redirect()->route('user.catalouge.index')->with('error', __('alert.permitError'));
    }
}
