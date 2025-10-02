<?php

namespace App\Repositories;

use App\Models\Router;
use App\Repositories\Interfaces\RouterRepositoryInterface;
use Illuminate\Routing\Route;

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

    public function findByCanonical($canonical)
    {
        return Router::where('canonical', $canonical)->first();
    }
}
