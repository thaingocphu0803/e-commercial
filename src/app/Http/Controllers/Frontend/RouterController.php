<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\RouterRepository;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isNull;

class RouterController extends Controller
{
    private $routerRepository;

    public function __construct(RouterRepository $routerRepository)
    {
        $this->routerRepository = $routerRepository;
    }

    public function index($canonical = '', Request $request){
        $router =  $this->routerRepository->findByCanonical($canonical);
        $method = 'index';
        
        if(is_null($router)){
            return view('errors.404');
        }
        else{
            echo app($router->controllers)->{$method}($router->module_id, $request);
        }
    }
}
