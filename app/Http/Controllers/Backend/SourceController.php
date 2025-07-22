<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSourceRequest;
use App\Http\Requests\UpdateSourceRequest;
use App\Models\Language;
use App\Services\SourceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SourceController extends Controller
{
    protected $sourceService;

    public function __construct(
        SourceService $sourceService,
    ) {
        $this->sourceService = $sourceService;
    }

    public function index(Request $request)
    {
        Gate::authorize('modules', 'source.index');
        $sources = $this->sourceService->paginate($request);
        return view('Backend.promotion.source.index', [
            'sources' => $sources,
        ]);
    }

    public function create()
    {
        Gate::authorize('modules', 'source.create');

        return view('Backend.promotion.source.create');
    }

    public function store(StoreSourceRequest $request)
    {
        Gate::authorize('modules', 'source.create');
        if ($this->sourceService->create($request)) {
            return redirect()->route('source.index')->with('success',  __('alert.addSuccess', ['attribute'=> __('custom.source')]));
        }
        return redirect()->route('source.index')->with('error',  __('alert.addError', ['attribute'=> __('custom.source')]));
    }

    public function edit($id)
    {
        Gate::authorize('modules', 'source.update');
        $source = $this->sourceService->findById($id);

        return view('backend.promotion.source.create', compact('source'));
    }

    public function update($id, UpdateSourceRequest $request)
    {
        Gate::authorize('modules', 'source.update');
        if ($this->sourceService->update($id, $request)) {
            return redirect()->route('source.index')->with('success',  __('alert.updateSuccess', ['attribute'=> __('custom.source')]));
        }

        return redirect()->route('source.index')->with('error',  __('alert.updateError', ['attribute'=> __('custom.source')]));
    }

    public function delete($id)
    {
        Gate::authorize('modules', 'source.delete');
        $source = $this->sourceService->findById($id);

        return view('backend.promotion.source.delete', [
            'source' => $source
        ]);
    }

    public function destroy($id)
    {
        Gate::authorize('modules', 'source.delete');
        if ($this->sourceService->destroy($id)) {
            return redirect()->route('source.index')->with('success',  __('alert.deleteSuccess', ['attribute'=> __('custom.source')]));
        }

        return redirect()->route('source.index')->with('error',  __('alert.deleteError', ['attribute'=> __('custom.source')]));
    }
}
