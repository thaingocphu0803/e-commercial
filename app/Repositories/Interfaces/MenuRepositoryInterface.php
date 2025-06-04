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

    public function destroy($id);

    public function forceDestroy($id);

    public function updateStatus($payload);

    public function updateStatusAll($payload);

}
