<?php

namespace App\Services\Interfaces;

/**
 * Interface LanguageServiceInterface
 * @package App\Services\Interfaces
 */
interface LanguageServiceInterface
{
    public function getAll();

    public function paginate($number);

    public function create($request);

    public function update($id, $request);

    public function destroy($id);

    public function forceDestroy($id);

    public function updateStatus($payload);

    public function updateStatusAll($payload);

    public function changeCurrent($canonical);


}
