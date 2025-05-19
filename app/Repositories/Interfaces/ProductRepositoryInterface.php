<?php

namespace App\Repositories\Interfaces;

/**
 * Interface ProductRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface ProductRepositoryInterface
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

    public function updateProductLanguage($model, $payload = []);

    public function updateCatalougePivot($id, $payload = []);

    // public function updateByWhereIn($ids, $value);

}
