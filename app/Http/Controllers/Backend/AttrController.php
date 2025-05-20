<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttrRequest;
use App\Http\Requests\UpdateAttrRequest;
use App\Models\Language;
use App\Services\AttrService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AttrController extends Controller
{
    protected $attrService;

    public function __construct(
        AttrService $attrService,
    ) {
        $this->attrService = $attrService;
    }

    public function index(Request $request)
    {
        Gate::authorize('modules', 'attr.index');
        $attrs = $this->attrService->paginate($request);
        $listNode = $this->attrService->getToTree();


        return view('Backend.attr.attr.index', [
            'attrs' => $attrs,
            'listNode' => $listNode,
        ]);
    }

    public function create()
    {
        Gate::authorize('modules', 'attr.create');
        $listNode = $this->attrService->getToTree();
        $languages = Language::select('id', 'name')->get();

        return view('Backend.attr.attr.create', [
            'listNode' => $listNode,
            'languages' => $languages
        ]);
    }

    public function store(StoreAttrRequest $request)
    {
        Gate::authorize('modules', 'attr.create');
        if ($this->attrService->create($request)) {
            return redirect()->route('attr.index')->with('success',  __('alert.addSuccess', ['attribute'=> __('dashboard.attr')]));
        }
        return redirect()->route('attr.index')->with('error',  __('alert.addError', ['attribute'=> __('dashboard.attr')]));
    }

    public function edit($id)
    {
        Gate::authorize('modules', 'attr.update');
        $attr = $this->attrService->findById($id);
        $listNode = $this->attrService->getToTree();
        $languages = Language::select('id', 'name')->get();

        return view('backend.attr.attr.create', [
            'listNode' => $listNode,
            'languages' => $languages,
            'attr' => $attr

        ]);
    }

    public function update($id, UpdateAttrRequest $request)
    {
        Gate::authorize('modules', 'attr.update');
        if ($this->attrService->update($id, $request)) {
            return redirect()->route('attr.index')->with('success',  __('alert.updateSuccess', ['attribute'=> __('dashboard.attr')]));
        }

        return redirect()->route('attr.index')->with('error',  __('alert.updateError', ['attribute'=> __('dashboard.attr')]));
    }

    public function delete($id)
    {
        Gate::authorize('modules', 'attr.delete');
        $attr = $this->attrService->findById($id);

        return view('backend.attr.attr.delete', [
            'attr' => $attr
        ]);
    }

    public function destroy($id)
    {
        Gate::authorize('modules', 'attr.delete');
        if ($this->attrService->destroy($id)) {
            return redirect()->route('attr.index')->with('success',  __('alert.deleteSuccess', ['attribute'=> __('dashboard.attr')]));
        }

        return redirect()->route('attr.index')->with('error',  __('alert.deleteError', ['attribute'=> __('dashboard.attr')]));
    }
}
