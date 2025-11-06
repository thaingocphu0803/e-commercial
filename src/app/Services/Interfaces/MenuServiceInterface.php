<?php

namespace App\Services\Interfaces;

/**
 * Interface MenuServiceInterface
 * @package App\Services\Interfaces
 */
interface MenuServiceInterface
{
    public function paginate($number);

    public function create($request, $languageId);

    public function updateStatus($payload);

    public function updateStatusAll($payload);

    public function childSave($request, $parent_id, $parent_menu_catalouge_id, $languageId);

    public function toTreeById($id);

    public function reBuildTree($newTree);
}
