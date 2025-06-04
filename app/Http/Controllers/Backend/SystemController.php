<?php

namespace App\Http\Controllers\Backend;

use App\Classes\System;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSystemRequest;
use App\Models\Language;
use App\Services\SystemService;
use Illuminate\Support\Facades\Gate;

class SystemController extends Controller
{
    private $system;
    private $systemService;
    private $languageId;

    public function __construct(
        System $system,
        SystemService $systemService
    )
    {
        $this->system = $system;
        $this->systemService = $systemService;
    }
    public function index(){
        $data = $this->system->config();
        $systemConfig = $this->systemService->all();
        return view('Backend.system.index', compact('data', 'systemConfig'));
    }

    public function store(StoreSystemRequest $request){
        Gate::authorize('modules', 'system.create');
        $locale = app()->getLocale();
        $language = Language::where('canonical', $locale)->first();
        $this->languageId =$language->id;

        if ($this->systemService->create($request, $this->languageId)) {
            return redirect()->route('system.index')->with('success', __('alert.addSuccess', ['attribute'=> __('custom.systemCo')]));
        }
        return redirect()->route('system.index')->with('error', __('alert.addError', ['attribute'=> __('custom.systemCo')]));

    }
}
