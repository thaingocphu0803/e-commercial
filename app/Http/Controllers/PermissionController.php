<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Models\Permission;
use App\Services\PermissionService;
use Illuminate\Http\Request;

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
        $permissions = $this->permissionService->paginate($request);
        return view('Backend.permission.index', [
            'permissions' => $permissions
        ]);
    }

    public function create()
    {
        return view('Backend.permission.create');
    }

    public function store(StorePermissionRequest $request)
    {
        if ($this->permissionService->create($request)) {
            return redirect()->route('permission.index')->with('success', __('alert.addSuccess', ['attribute'=> __('dashboard.permission')]));
        }
        return redirect()->route('permission.index')->with('error', __('alert.addError', ['attribute'=> __('dashboard.permission')]));
    }

    public function edit(Permission $permission)
    {
        return view('backend.permission.create', [
            'permission' => $permission
        ]);
    }

    public function update($id, UpdatePermissionRequest $request)
    {

        if ($this->permissionService->update($id, $request)) {
            return redirect()->route('permission.index')->with('success', __('alert.updateSuccess', ['attribute'=> __('dashboard.permission')]));
        }

        return redirect()->route('permission.index')->with('error', __('alert.updateError', ['attribute'=> __('dashboard.permission')]));
    }

    public function delete(Permission $permission)
    {
        return view('backend.permission.delete', [
            'permission' => $permission
        ]);
    }

    public function destroy($id)
    {
        if ($this->permissionService->destroy($id)) {
            return redirect()->route('permission.index')->with('success', __('alert.deleteSuccess', ['attribute'=> __('dashboard.permission')]));
        }

        return redirect()->route('permission.index')->with('error', __('alert.deleteError', ['attribute'=> __('dashboard.permission')]));
    }
}
