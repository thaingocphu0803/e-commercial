<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttrCatalougeRequest;
use App\Http\Requests\UpdateAttrCatalougeRequest;
use App\Models\Language;
use App\Services\AttrCatalougeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AttrCatalougeController extends Controller
{
    protected $attrCatalougeService;

    public function __construct(
        AttrCatalougeService $attrCatalougeService,
    ) {
        $this->attrCatalougeService = $attrCatalougeService;
    }

    public function index(Request $request)
    {
        Gate::authorize('modules', 'attr.catalouge.index');
        $attrCatalouges = $this->attrCatalougeService->paginate($request);

        return view('Backend.attr.catalouge.index', [
            'attrCatalouges' => $attrCatalouges
        ]);
    }

    public function create()
    {
        Gate::authorize('modules', 'attr.catalouge.create');
        $listNode = $this->attrCatalougeService->getToTree();
        $languages = Language::select('id', 'name')->get();

        return view('Backend.attr.catalouge.create', [
            'listNode' => $listNode,
            'languages' => $languages
        ]);
    }

    public function store(StoreAttrCatalougeRequest $request)
    {
        Gate::authorize('modules', 'attr.catalouge.create');
        if ($this->attrCatalougeService->create($request)) {
            return redirect()->route('attr.catalouge.index')->with('success', __('alert.addSuccess', ['attribute'=> __('custom.attrCatalouge')]));
        }
        return redirect()->route('attr.catalouge.index')->with('error', __('alert.addError', ['attribute'=> __('custom.attrCatalouge')]));
    }

    public function edit($id)
    {
        Gate::authorize('modules', 'attr.catalouge.update');
        $attrCatalouge =$this->attrCatalougeService->findById($id);

        $listNode = $this->attrCatalougeService->getToTree($id);
        $languages = Language::select('id', 'name')->get();
        return view('backend.attr.catalouge.create', [
            'listNode' => $listNode,
            'languages' => $languages,
            'attrCatalouge' => $attrCatalouge

        ]);
    }

    public function update($id, UpdateAttrCatalougeRequest $request)
    {
        Gate::authorize('modules', 'attr.catalouge.update');
        if ($this->attrCatalougeService->update($id, $request)) {
            return redirect()->route('attr.catalouge.index')->with('success', __('alert.updateSuccess', ['attribute'=> __('custom.attrCatalouge')]));
        }

        return redirect()->route('attr.catalouge.index')->with('error', __('alert.updateError', ['attribute'=> __('custom.attrCatalouge')]));
    }

    public function delete($id)
    {
        Gate::authorize('modules', 'attr.catalouge.delete');
        $attrCatalouge =$this->attrCatalougeService->findById($id);

        return view('backend.attr.catalouge.delete', [
            'attrCatalouge' => $attrCatalouge
        ]);
    }

    public function destroy($id)
    {
        Gate::authorize('modules', 'attr.catalouge.delete');
        if ($this->attrCatalougeService->destroy($id)) {
            return redirect()->route('attr.catalouge.index')->with('success', __('alert.deleteSuccess', ['attribute'=> __('custom.attrCatalouge')]));
        }

        return redirect()->route('attr.catalouge.index')->with('error', __('alert.deleteError', ['attribute'=> __('custom.attrCatalouge')]));
    }
}
