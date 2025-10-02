<?php

namespace App\Http\Controllers\Fontend;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $payload = $request->route()->parameters();

        $product = $this->productService->getProductWithVariant($payload);

        dd($product);
    }
}
