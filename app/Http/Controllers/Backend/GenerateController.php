<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGenerateRequest;
use App\Http\Requests\UpdateGenerateRequest;
use App\Models\Generate;
use App\Services\GenerateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GenerateController extends Controller
{
    protected $generateService;

    public function __construct(
        GenerateService $generateService,
    ) {
        $this->generateService = $generateService;
    }

    public function index(Request $request)
    {
        Gate::authorize('modules', 'generate.index');
        $generates = $this->generateService->paginate($request);

        return view('Backend.generate.index', [
            'generates' => $generates
        ]);
    }

    public function create()
    {
        Gate::authorize('modules', 'generate.create');
        return view('Backend.generate.create');
    }

    public function store(StoreGenerateRequest $request)
    {
        Gate::authorize('modules', 'generate.create');
        if ($this->generateService->create($request)) {
            return redirect()->route('generate.index')->with('success', __('alert.addSuccess', ['attribute'=> __('custom.Generate')]));
        }
        return redirect()->route('generate.index')->with('error', __('alert.addError', ['attribute'=> __('custom.Generate')]));
    }

    public function edit(Generate $generate)
    {
        Gate::authorize('modules', 'generate.update');
        return view('backend.generate.create', [
            'generate' => $generate
        ]);
    }

    public function update($id, UpdateGenerateRequest $request)
    {
        Gate::authorize('modules', 'generate.update');
        if ($this->generateService->update($id, $request)) {
            return redirect()->route('generate.index')->with('success', __('alert.updateSuccess', ['attribute'=> __('custom.Generate')]));
        }

        return redirect()->route('generate.index')->with('error', __('alert.updateError', ['attribute'=> __('custom.Generate')]));
    }

    public function delete(Generate $generate)
    {
        Gate::authorize('modules', 'generate.delete');
        return view('backend.generate.delete', [
            'generate' => $generate
        ]);
    }

    public function destroy($id)
    {
        Gate::authorize('modules', 'generate.delete');
        if ($this->generateService->destroy($id)) {
            return redirect()->route('generate.index')->with('success', __('alert.deleteSuccess', ['attribute'=> __('custom.Generate')]));
        }

        return redirect()->route('generate.index')->with('error', __('alert.deleteError', ['attribute'=> __('custom.Generate')]));
    }
}
