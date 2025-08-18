<?php

namespace App\Http\ViewComposers;

use App\Services\SystemService;
use Illuminate\View\View;

class SystemComposer
{
    /**
     * Create a new class instance.
     */
    private $systemService;

    public function __construct(SystemService $systemService)
    {
        $this->systemService = $systemService;
    }

    public function compose(View $view){
            $system = $this->systemService->all();
            $view->with('system', $system);
    }
}
