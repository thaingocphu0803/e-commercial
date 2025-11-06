<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\ProductCatalougeService;
use App\Services\ProductService;
use App\Services\SlideService;

class HomeController extends Controller
{
    private $slideService;
    private $productCatalougeService;
    private $productService;

    public function __construct(
        SlideService $slideService,
        ProductCatalougeService $productCatalougeService,
        ProductService $productService
        )
    {
        $this->slideService = $slideService;
        $this->productCatalougeService = $productCatalougeService;
        $this->productService = $productService;
    }

    public function index(){
        // get slides
        [$slides, $banners] =$this->slideService->findByKeyword(['main-slide', 'banner']);
        $slideItems = json_decode($slides->item, true);
        $bannerItems = json_decode($banners->item, true);
        $slideSettings = $slides->settings;

        // get products
        $products = $this->productService->getProductWithPromotion();

        // get product catalouge
        $productCategories = $this->productCatalougeService->getAll();

        return view('Frontend.homepage.home.index', compact('slideItems', 'bannerItems' ,'slideSettings', 'productCategories', 'products'));
    }
}
