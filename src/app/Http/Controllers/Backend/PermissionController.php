<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Models\Permission;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class PermissionController extends Controller
{
    protected $permissionService;

    public function __construct(
        PermissionService $permissionService,
    ) {
        $this->permissionService = $permissionService;
    }

    public function index(Request $request)
    {
        Gate::authorize('modules', 'permission.index');
        $permissions = $this->permissionService->paginate($request);
        return view('Backend.permission.index', [
            'permissions' => $permissions
        ]);
    }

    public function create()
    {
        Gate::authorize('modules', 'permission.create');

        return view('Backend.permission.create');
    }

    public function store(StorePermissionRequest $request)
    {
        Gate::authorize('modules', 'permission.create');
        if ($this->permissionService->create($request)) {
            return redirect()->route('permission.index')->with('success', __('alert.addSuccess', ['attribute'=> __('custom.permission')]));
        }
        return redirect()->route('permission.index')->with('error', __('alert.addError', ['attribute'=> __('custom.permission')]));
    }

    public function edit(Permission $permission)
    {
        Gate::authorize('modules', 'permission.update');
        return view('backend.permission.create', [
            'permission' => $permission
        ]);
    }

    public function update($id, UpdatePermissionRequest $request)
    {
        Gate::authorize('modules', 'permission.update');
        if ($this->permissionService->update($id, $request)) {
            return redirect()->route('permission.index')->with('success', __('alert.updateSuccess', ['attribute'=> __('custom.permission')]));
        }

        return redirect()->route('permission.index')->with('error', __('alert.updateError', ['attribute'=> __('custom.permission')]));
    }

    public function delete(Permission $permission)
    {
        Gate::authorize('modules', 'permission.delete');
        return view('backend.permission.delete', [
            'permission' => $permission
        ]);
    }

    public function destroy($id)
    {
        Gate::authorize('modules', 'permission.delete');
        if ($this->permissionService->destroy($id)) {
            return redirect()->route('permission.index')->with('success', __('alert.deleteSuccess', ['attribute'=> __('custom.permission')]));
        }

        return redirect()->route('permission.index')->with('error', __('alert.deleteError', ['attribute'=> __('custom.permission')]));
    }
}
