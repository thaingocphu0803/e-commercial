<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\ProvinceRepository;
use App\Services\ProductService;
use App\Services\AttrCatalougeService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{
    protected $productService;
    protected $attrCatalougeService;
    protected $orderService;
    protected $provinceRepository;

    public function __construct(
        ProductService $productService,
        AttrCatalougeService $attrCatalougeService,
        OrderService $orderService,
        ProvinceRepository $provinceRepository,
    ) {
        $this->productService = $productService;
        $this->attrCatalougeService = $attrCatalougeService;
        $this->orderService = $orderService;
        $this->provinceRepository = $provinceRepository;
    }

    public function index(Request $request)
    {
        Gate::authorize('modules', 'order.index');
        $orders = $this->orderService->paginate($request);
        return view('Backend.order.index', compact('orders'));
    }

    public function detail($code)
    {
        $order = $this->orderService->findById($code);
        $provinces = $this->provinceRepository->getAll();

        return view('Backend.order.detail' , compact('order', 'provinces'));
    }

    // public function store(StoreProductRequest $request)
    // {
    //     Gate::authorize('modules', 'product.create');
    //     if ($this->productService->create($request)) {
    //         return redirect()->route('product.index')->with('success',  __('alert.addSuccess', ['attribute'=> __('custom.product')]));
    //     }
    //     return redirect()->route('product.index')->with('error',  __('alert.addError', ['attribute'=> __('custom.product')]));
    // }

    // public function edit($id)
    // {
    //     Gate::authorize('modules', 'product.update');
    //     $product = $this->productService->findById($id);
    //     $listNode = $this->productService->getToTree();
    //     $listAttr = $this->attrCatalougeService->getToTree();
    //     $languages = Language::select('id', 'name')->get();

    //     return view('backend.product.product.create', [
    //         'listNode' => $listNode,
    //         'listAttr' => $listAttr,
    //         'languages' => $languages,
    //         'product' => $product

    //     ]);
    // }

    // public function update($id, UpdateProductRequest $request)
    // {
    //     Gate::authorize('modules', 'product.update');
    //     if ($this->productService->update($id, $request)) {
    //         return redirect()->route('product.index')->with('success',  __('alert.updateSuccess', ['attribute'=> __('custom.product')]));
    //     }

    //     return redirect()->route('product.index')->with('error',  __('alert.updateError', ['attribute'=> __('custom.product')]));
    // }

    // public function delete($id)
    // {
    //     Gate::authorize('modules', 'product.delete');
    //     $product = $this->productService->findById($id);

    //     return view('backend.product.product.delete', [
    //         'product' => $product
    //     ]);
    // }

    // public function destroy($id)
    // {
    //     Gate::authorize('modules', 'product.delete');
    //     if ($this->productService->destroy($id)) {
    //         return redirect()->route('product.index')->with('success',  __('alert.deleteSuccess', ['attribute'=> __('custom.product')]));
    //     }

    //     return redirect()->route('product.index')->with('error',  __('alert.deleteError', ['attribute'=> __('custom.product')]));
    // }
}
