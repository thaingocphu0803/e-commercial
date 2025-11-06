<?php

namespace App\Repositories\Interfaces;

/**
 * Interface MenuRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface MenuRepositoryInterface
{
    public function paginate($request);

    public function create($payload, $parent_id = null);

    public function createPivotLanguage($model, $languageId,$payload);

    public function update($id, $payload);

    public function destroy($ids = []);

    public function updateStatus($payload);

    public function updateStatusAll($payload);

    public function toTreeById($id);

    public function reBuildTree($newTree);

}
