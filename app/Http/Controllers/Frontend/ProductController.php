<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
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

    public function index($id, Request $request)
    {
        $request->except('_token');

        $payload = [
            'product_id' => $id,
            'promotion_id' => $request->input('promotion_id'),
            'uuid' => $request->input('uuid')
        ];

        $product = $this->productService->getProductWithVariant($payload);
        $seo = seo((object)$product);
        $productCategories = $this->productCatalougeService->paginate($request);

        return view('Frontend.product.product.index', compact('product', 'seo', 'productCategories'));
    }
}
