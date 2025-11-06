<?php

namespace App\Repositories;

use App\Models\ProductVariantAttr;
use App\Repositories\Interfaces\ProductVariantAttrRepositoryInterface;

class ProductVariantAttrRepository implements ProductVariantAttrRepositoryInterface {
    public function createBash($variantAttr){
        return ProductVariantAttr::insert($variantAttr);
    }
}
