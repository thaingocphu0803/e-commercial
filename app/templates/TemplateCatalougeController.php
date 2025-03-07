<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store{ModuleTemplate}Request;
use App\Http\Requests\Update{ModuleTemplate}Request;
use App\Models\Language;
use App\Services\{ModuleTemplate}Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class {ModuleTemplate}Controller extends Controller
{
    protected ${moduleTemplate}Service;

    public function __construct(
        {ModuleTemplate}Service ${moduleTemplate}Service,
    ) {
        $this->{moduleTemplate}Service = ${moduleTemplate}Service;
    }

    public function index(Request $request)
    {
        Gate::authorize('modules', '{moduleView}.index');
        ${moduleTemplate}s = $this->{moduleTemplate}Service->paginate($request);

        return view('Backend.{moduleView}.index', [
            '{moduleTemplate}s' => ${moduleTemplate}s
        ]);
    }

    public function create()
    {
        Gate::authorize('modules', '{moduleView}.create');
        $listNode = $this->{moduleTemplate}Service->getToTree();
        $languages = Language::select('id', 'name')->get();

        return view('Backend.{moduleView}.create', [
            'listNode' => $listNode,
            'languages' => $languages
        ]);
    }

    public function store(Store{ModuleTemplate}Request $request)
    {
        Gate::authorize('modules', '{moduleView}.create');
        if ($this->{moduleTemplate}Service->create($request)) {
            return redirect()->route('{moduleView}.index')->with('success', __('alert.addSuccess', ['attribute'=> __('dashboard.{moduleTemplate}')]));
        }
        return redirect()->route('{moduleView}.index')->with('error', __('alert.addError', ['attribute'=> __('dashboard.{moduleTemplate}')]));
    }

    public function edit($id)
    {
        Gate::authorize('modules', '{moduleView}.update');
        ${moduleTemplate} =$this->{moduleTemplate}Service->findById($id);

        $listNode = $this->{moduleTemplate}Service->getToTree($id);
        $languages = Language::select('id', 'name')->get();
        return view('backend.{moduleView}.create', [
            'listNode' => $listNode,
            'languages' => $languages,
            '{moduleTemplate}' => ${moduleTemplate}

        ]);
    }

    public function update($id, Update{ModuleTemplate}Request $request)
    {
        Gate::authorize('modules', '{moduleView}.update');
        if ($this->{moduleTemplate}Service->update($id, $request)) {
            return redirect()->route('{moduleView}.index')->with('success', __('alert.updateSuccess', ['attribute'=> __('dashboard.{moduleTemplate}')]));
        }

        return redirect()->route('{moduleView}.index')->with('error', __('alert.updateError', ['attribute'=> __('dashboard.{moduleTemplate}')]));
    }

    public function delete($id)
    {
        Gate::authorize('modules', '{moduleView}.delete');
        ${moduleTemplate} =$this->{moduleTemplate}Service->findById($id);

        return view('backend.{moduleView}.delete', [
            '{moduleTemplate}' => ${moduleTemplate}
        ]);
    }

    public function destroy($id)
    {
        Gate::authorize('modules', '{moduleView}.delete');
        if ($this->{moduleTemplate}Service->destroy($id)) {
            return redirect()->route('{moduleView}.index')->with('success', __('alert.deleteSuccess', ['attribute'=> __('dashboard.{moduleTemplate}')]));
        }

        return redirect()->route('{moduleView}.index')->with('error', __('alert.deleteError', ['attribute'=> __('dashboard.{moduleTemplate}')]));
    }
}
