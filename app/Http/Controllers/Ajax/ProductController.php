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
        if(count($products)){
            $response =[
                'code' => 0,
                'status' => 'ok',
                'object' => $products,
            ];
        }

        echo json_encode([
            'code' => $response['code'] ?? 1,
            'status' => $response['status'] ?? 'ng',
            'object' =>  $response['object'] ?? []
        ]);
    }


    public function loadProductCatalougePromotion(Request $request)
    {
        $productCatalouges  = $this->productCatalougeService->loadProductCatalouge($request);
        if(count($productCatalouges)){
            $response =[
                'code' => 0,
                'status' => 'ok',
                'object' => $productCatalouges,
            ];
        }

        echo json_encode([
            'code' => $response['code'] ?? 1,
            'status' => $response['status'] ?? 'ng',
            'object' =>  $response['object'] ?? []
        ]);
    }
}
