<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use App\Repositories\ProvinceRepository;
use App\Services\CustomerCatalougeService;
use App\Services\CustomerService;
use App\Services\SourceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CustomerController extends Controller
{
    protected $customerService;
    protected $provinceRepository;
    protected $customerCatalougeService;
    protected $sourceService;

    public function __construct(
        CustomerService $customerService,
        ProvinceRepository $provinceRepository,
        CustomerCatalougeService $customerCatalougeService,
        SourceService $sourceService
        )
    {
        $this->customerService = $customerService;
        $this->provinceRepository = $provinceRepository;
        $this->customerCatalougeService = $customerCatalougeService;
        $this->sourceService = $sourceService;

    }

    public function index(Request $request){
        Gate::authorize('modules', 'customer.index');
        $customers = $this->customerService->paginate($request);

        $customerCatalouges = $this->customerCatalougeService->getAll();


        return view('Backend.customer.customer.index', [
            'customers' => $customers,
            'customerCatalouges' => $customerCatalouges
        ]);
    }

    public function create(){
        Gate::authorize('modules', 'customer.create');
        $provinces = $this->provinceRepository->getAll();
        $customerCatalouges = $this->customerCatalougeService->getAll();
        $sources =$this->sourceService->getAll();

        return view('Backend.customer.customer.create', [
            'provinces' => $provinces,
            'customerCatalouges' => $customerCatalouges,
            'sources' => $sources
        ]);
    }

    public function store(StoreCustomerRequest $request){
        Gate::authorize('modules', 'customer.create');
        if($this->customerService->create($request)){
            return redirect()->route('customer.index')->with('success', __('alert.addSuccess', ['attribute'=> __('custom.customer')]));
        }

        return redirect()->route('customer.index')->with('error', __('alert.addError', ['attribute'=> __('custom.customer')]));
    }

    public function edit(Customer $customer){
        Gate::authorize('modules', 'customer.update');
        $provinces = $this->provinceRepository->getAll();
        $customerCatalouges = $this->customerCatalougeService->getAll();
        $sources =$this->sourceService->getAll();

        return view('backend.customer.customer.create', [
            'customerCatalouges' => $customerCatalouges,
            'provinces' => $provinces,
            'customer' => $customer,
            'sources' => $sources
        ]);
    }

    public function update($id, UpdateCustomerRequest $request){
        Gate::authorize('modules', 'customer.update');
        if($this->customerService->update($id, $request)){
            return redirect()->route('customer.index')->with('success', __('alert.updateSuccess', ['attribute'=> __('custom.customer')]));
        }

        return redirect()->route('customer.index')->with('error', __('alert.updateError', ['attribute'=> __('custom.customer')]));
    }

    public function delete(Customer $customer){
        Gate::authorize('modules', 'customer.delete');
        return view('backend.customer.customer.delete', [
            'customer' => $customer
        ]);
    }

    public function destroy($id){
        Gate::authorize('modules', 'customer.delete');
        if($this->customerService->destroy($id)){
            return redirect()->route('customer.index')->with('success', __('alert.deleteSuccess', ['attribute'=> __('custom.customer')]));
        }

        return redirect()->route('customer.index')->with('error', __('alert.deleteError', ['attribute'=> __('custom.customer')]));
    }

}
