<?php

namespace App\Repositories;

use App\Models\Router;
use App\Repositories\Interfaces\RouterRepositoryInterface;

class RouterRepository implements RouterRepositoryInterface {
    public function create($router)
    {
        return Router::create($router);
    }

    public function update($router)
    {
        $routerModel = Router::where([
            'module_id' => $router['module_id'],
            'controllers' => $router['controllers']
        ])->firstOrFail();

        if ($routerModel) {
            $routerModel->update($router);
        }
    }
}
