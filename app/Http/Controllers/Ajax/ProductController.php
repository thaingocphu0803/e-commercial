<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\ProductCatalouge;
use App\Services\ProductCatalougeService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $productService;
    private $productCatalougeService;
    public function __construct(ProductService $productService, ProductCatalougeService $productCatalougeService)
    {
        $this->productService = $productService;
        $this->productCatalougeService = $productCatalougeService;
    }

    public function loadProductPromotion(Request $request)
    {
        $products  = $this->productService->loadProductWithVariant($request);
        $this->sendResponse($products);
    }


    public function loadProductCatalougePromotion(Request $request)
    {
        $productCatalouges  = $this->productCatalougeService->loadProductCatalouge($request);
        $this->sendResponse($productCatalouges);
    }

    public function loadProductWithVariant(Request $request){
        $payload = $request->except('_token');

        $product = $this->productService->getProductWithVariant($payload);
        $this->sendResponse($product);

    }

    public function loadProductByVariant(Request $request){
        $product  = $this->productService->getProductByVariant($request);
        $this->sendResponse($product);
    }
}
