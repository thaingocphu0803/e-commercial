<?php

namespace App\Services\Interfaces;

/**
 * Interface ProductServiceInterface
 * @package App\Services\Interfaces
 */
interface ProductServiceInterface
{
    public function getAll();

    public function getToTree();

    public function findById($id);

    public function getProductWithVariant($payload);

    public function getProductByVariant($request);

    public function getProductWithPromotion($product_catalouge_id = null);

    public function paginate($number);

    public function create($request);

    public function update($id, $request);

    public function destroy($id);

    public function forceDestroy($id);

    public function updateStatus($payload);

    public function updateStatusAll($payload);

    public function createVariant($product, $request);

    public function loadProductWithVariant($request);
}
