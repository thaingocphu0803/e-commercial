<?php

namespace App\Services\Interfaces;

/**
 * Interface ProductCatalougeServiceInterface
 * @package App\Services\Interfaces
 */
interface ProductCatalougeServiceInterface
{
    public function getAll();

    public function getBreadcrumb($id);

    public function getToTree($id = null);

    public function findById($id);

    public function paginate($number);

    public function create($request);

    public function update($id, $request);

    public function destroy($id);

    public function forceDestroy($id);

    public function updateStatus($payload);

    public function updateStatusAll($payload);

    public function loadProductCatalouge($request);


}
