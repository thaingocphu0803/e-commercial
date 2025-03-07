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
        Gate::authorize('modules', '{moduleTemplate}.index');
        ${moduleTemplate}s = $this->{moduleTemplate}Service->paginate($request);
        $listNode = $this->{moduleTemplate}Service->getToTree();

        return view('Backend.{moduleTemplate}.{moduleTemplate}.index', [
            '{moduleTemplate}s' => ${moduleTemplate}s,
            'listNode' => $listNode,
        ]);
    }

    public function create()
    {
        Gate::authorize('modules', '{moduleTemplate}.create');
        $listNode = $this->{moduleTemplate}Service->getToTree();
        $languages = Language::select('id', 'name')->get();

        return view('Backend.{moduleTemplate}.{moduleTemplate}.create', [
            'listNode' => $listNode,
            'languages' => $languages
        ]);
    }

    public function store(Store{ModuleTemplate}Request $request)
    {
        Gate::authorize('modules', '{moduleTemplate}.create');
        if ($this->{moduleTemplate}Service->create($request)) {
            return redirect()->route('{moduleTemplate}.index')->with('success',  __('alert.addSuccess', ['attribute'=> __('dashboard.{moduleTemplate}')]));
        }
        return redirect()->route('{moduleTemplate}.index')->with('error',  __('alert.addError', ['attribute'=> __('dashboard.{moduleTemplate}')]));
    }

    public function edit($id)
    {
        Gate::authorize('modules', '{moduleTemplate}.update');
        ${moduleTemplate} = $this->{moduleTemplate}Service->findById($id);
        $listNode = $this->{moduleTemplate}Service->getToTree();
        $languages = Language::select('id', 'name')->get();

        return view('backend.{moduleTemplate}.{moduleTemplate}.create', [
            'listNode' => $listNode,
            'languages' => $languages,
            '{moduleTemplate}' => ${moduleTemplate}

        ]);
    }

    public function update($id, Update{ModuleTemplate}Request $request)
    {
        Gate::authorize('modules', '{moduleTemplate}.update');
        if ($this->{moduleTemplate}Service->update($id, $request)) {
            return redirect()->route('{moduleTemplate}.index')->with('success',  __('alert.updateSuccess', ['attribute'=> __('dashboard.{moduleTemplate}')]));
        }

        return redirect()->route('{moduleTemplate}.index')->with('error',  __('alert.updateError', ['attribute'=> __('dashboard.{moduleTemplate}')]));
    }

    public function delete($id)
    {
        Gate::authorize('modules', '{moduleTemplate}.delete');
        ${moduleTemplate} = $this->{moduleTemplate}Service->findById($id);

        return view('backend.{moduleTemplate}.{moduleTemplate}.delete', [
            '{moduleTemplate}' => ${moduleTemplate}
        ]);
    }

    public function destroy($id)
    {
        Gate::authorize('modules', '{moduleTemplate}.delete');
        if ($this->{moduleTemplate}Service->destroy($id)) {
            return redirect()->route('{moduleTemplate}.index')->with('success',  __('alert.deleteSuccess', ['attribute'=> __('dashboard.{moduleTemplate}')]));
        }

        return redirect()->route('{moduleTemplate}.index')->with('error',  __('alert.deleteError', ['attribute'=> __('dashboard.{moduleTemplate}')]));
    }
}
