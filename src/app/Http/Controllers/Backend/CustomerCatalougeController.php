<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerCatalougeRequest;
use App\Http\Requests\UpdateCustomerCatalougeRequest;
use App\Models\CustomerCatalouge;
use App\Services\PermissionService;
use App\Services\CustomerCatalougeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CustomerCatalougeController extends Controller
{
    protected $customerCatalougeService;
    protected $permissionService;

    public function __construct(
        CustomerCatalougeService $customerCatalougeService,
        PermissionService $permissionService
    ) {
        $this->customerCatalougeService = $customerCatalougeService;
        $this->permissionService = $permissionService;
    }

    public function index(Request $request)
    {
        Gate::authorize('modules', 'customer.catalouge.index');
        $customerCatalouges = $this->customerCatalougeService->paginate($request);
        return view('Backend.customer.catalouge.index', [
            'customerCatalouges' => $customerCatalouges
        ]);
    }

    public function create()
    {
        Gate::authorize('modules', 'customer.catalouge.create');
        return view('Backend.customer.catalouge.create');
    }

    public function store(StoreCustomerCatalougeRequest $request)
    {
        Gate::authorize('modules', 'customer.catalouge.create');
        if ($this->customerCatalougeService->create($request)) {
            return redirect()->route('customer.catalouge.index')->with('success', __('alert.addSuccess', ['attribute' => __('custom.Catalouge')]));
        }
        return redirect()->route('customer.catalouge.index')->with('error', __('alert.addError', ['attribute' => __('custom.Catalouge')]));
    }

    public function edit(CustomerCatalouge $customerCatalouge)
    {
        Gate::authorize('modules', 'customer.catalouge.update');
        return view('backend.customer.catalouge.create', [
            'customerCatalouge' => $customerCatalouge
        ]);
    }

    public function update($id, UpdateCustomerCatalougeRequest $request)
    {
        Gate::authorize('modules', 'customer.catalouge.update');
        if ($this->customerCatalougeService->update($id, $request)) {
            return redirect()->route('customer.catalouge.index')->with('success', __('alert.updateSuccess', ['attribute' => __('custom.Catalouge')]));
        }

        return redirect()->route('customer.catalouge.index')->with('error', __('alert.updateError', ['attribute' => __('custom.Catalouge')]));
    }

    public function delete(CustomerCatalouge $customerCatalouge)
    {
        Gate::authorize('modules', 'customer.catalouge.delete');
        return view('backend.customer.catalouge.delete', [
            'customerCatalouge' => $customerCatalouge
        ]);
    }

    public function destroy($id)
    {
        Gate::authorize('modules', 'customer.catalouge.delete');
        if ($this->customerCatalougeService->destroy($id)) {
            return redirect()->route('customer.catalouge.index')->with('success', __('alert.deleteSuccess', ['attribute' => __('custom.Catalouge')]));
        }

        return redirect()->route('customer.catalouge.index')->with('error', __('alert.deleteError', ['attribute' => __('custom.Catalouge')]));
    }
}
