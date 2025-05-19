<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductCatalougeRequest;
use App\Http\Requests\UpdateProductCatalougeRequest;
use App\Models\Language;
use App\Services\ProductCatalougeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProductCatalougeController extends Controller
{
    protected $productCatalougeService;

    public function __construct(
        ProductCatalougeService $productCatalougeService,
    ) {
        $this->productCatalougeService = $productCatalougeService;
    }

    public function index(Request $request)
    {
        Gate::authorize('modules', 'product.catalouge.index');
        $productCatalouges = $this->productCatalougeService->paginate($request);

        return view('Backend.product.catalouge.index', [
            'productCatalouges' => $productCatalouges
        ]);
    }

    public function create()
    {
        Gate::authorize('modules', 'product.catalouge.create');
        $listNode = $this->productCatalougeService->getToTree();
        $languages = Language::select('id', 'name')->get();

        return view('Backend.product.catalouge.create', [
            'listNode' => $listNode,
            'languages' => $languages
        ]);
    }

    public function store(StoreProductCatalougeRequest $request)
    {
        Gate::authorize('modules', 'product.catalouge.create');
        if ($this->productCatalougeService->create($request)) {
            return redirect()->route('product.catalouge.index')->with('success', __('alert.addSuccess', ['attribute'=> __('dashboard.productCatalouge')]));
        }
        return redirect()->route('product.catalouge.index')->with('error', __('alert.addError', ['attribute'=> __('dashboard.productCatalouge')]));
    }

    public function edit($id)
    {
        Gate::authorize('modules', 'product.catalouge.update');
        $productCatalouge =$this->productCatalougeService->findById($id);

        $listNode = $this->productCatalougeService->getToTree($id);
        $languages = Language::select('id', 'name')->get();
        return view('backend.product.catalouge.create', [
            'listNode' => $listNode,
            'languages' => $languages,
            'productCatalouge' => $productCatalouge

        ]);
    }

    public function update($id, UpdateProductCatalougeRequest $request)
    {
        Gate::authorize('modules', 'product.catalouge.update');
        if ($this->productCatalougeService->update($id, $request)) {
            return redirect()->route('product.catalouge.index')->with('success', __('alert.updateSuccess', ['attribute'=> __('dashboard.productCatalouge')]));
        }

        return redirect()->route('product.catalouge.index')->with('error', __('alert.updateError', ['attribute'=> __('dashboard.productCatalouge')]));
    }

    public function delete($id)
    {
        Gate::authorize('modules', 'product.catalouge.delete');
        $productCatalouge =$this->productCatalougeService->findById($id);

        return view('backend.product.catalouge.delete', [
            'productCatalouge' => $productCatalouge
        ]);
    }

    public function destroy($id)
    {
        Gate::authorize('modules', 'product.catalouge.delete');
        if ($this->productCatalougeService->destroy($id)) {
            return redirect()->route('product.catalouge.index')->with('success', __('alert.deleteSuccess', ['attribute'=> __('dashboard.productCatalouge')]));
        }

        return redirect()->route('product.catalouge.index')->with('error', __('alert.deleteError', ['attribute'=> __('dashboard.productCatalouge')]));
    }
}
