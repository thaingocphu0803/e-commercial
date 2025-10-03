<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\ProductCatalougeService;
use App\Services\ProductService;

class ProductCatalougeController extends Controller
{
    private $productCatalougeService;
    private $productService;


    public function __construct(
        ProductCatalougeService $productCatalougeService,
        ProductService $productService
    )
    {
        $this->productCatalougeService = $productCatalougeService;

        $this->productService = $productService;

    }

    public function index($id, $request){
        $productCatalouge = $this->productCatalougeService->findById($id);
        $breadcrumbs = $this->productCatalougeService->getBreadcrumb($id);
        $products = $this->productService->getProductWithPromotion($id);


        $seo = seo($productCatalouge);

        return view('Frontend.product.catalouge.index', compact('seo', 'productCatalouge', 'breadcrumbs', 'products'));
    }
}
