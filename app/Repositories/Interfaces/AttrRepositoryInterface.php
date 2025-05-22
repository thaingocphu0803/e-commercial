<?php

namespace App\Repositories\Interfaces;

/**
 * Interface AttrRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface AttrRepositoryInterface
{
    public function getAll();

    public function getToTree();

    public function findById($id);

    public function paginate($request);

    public function create($payload);

    public function update($id, $payload);

    public function destroy($id);

    public function forceDestroy($id);

    public function updateStatus($payload);

    public function updateStatusAll($payload);

    public function createLanguagePivot($model, $payload = []);

    public function createCatalougePivot($model, $payload = []);

    public function updateAttrLanguage($model, $payload = []);

    public function updateCatalougePivot($id, $payload = []);

    public function searchAttr($search, $option);

    // public function updateByWhereIn($ids, $value);

}
