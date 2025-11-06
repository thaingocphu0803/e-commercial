<?php

namespace App\Repositories\Interfaces;

/**
 * Interface {ModuleName}RepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface {ModuleName}RepositoryInterface
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

    public function update{ModuleName}Language($model, $payload = []);

    public function updateCatalougePivot($id, $payload = []);

    // public function updateByWhereIn($ids, $value);

}
