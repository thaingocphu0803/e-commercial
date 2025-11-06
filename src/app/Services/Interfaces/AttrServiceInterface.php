<?php

namespace App\Services\Interfaces;

/**
 * Interface AttrServiceInterface
 * @package App\Services\Interfaces
 */
interface AttrServiceInterface
{
    public function getAll();

    public function getToTree();

    public function findById($id);

    public function paginate($number);

    public function create($request);

    public function update($id, $request);

    public function destroy($id);

    public function forceDestroy($id);

    public function updateStatus($payload);

    public function updateStatusAll($payload);

    public function searchAttr($searh, $option);

    public function findAttrByIdArr($attributesArray);

}
