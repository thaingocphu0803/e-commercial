<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeletePostCatalougeRequest;
use App\Http\Requests\StorePostCatalougeRequest;
use App\Http\Requests\UpdatePostCatalougeRequest;
use App\Models\Language;
use App\Services\PostCatalougeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostCatalougeController extends Controller
{
    protected $postCatalougeService;

    public function __construct(
        PostCatalougeService $postCatalougeService,
    ) {
        $this->postCatalougeService = $postCatalougeService;
    }

    public function index(Request $request)
    {
        Gate::authorize('modules', 'post.catalouge.index');
        $postCatalouges = $this->postCatalougeService->paginate($request);

        return view('Backend.post.catalouge.index', [
            'postCatalouges' => $postCatalouges
        ]);
    }

    public function create()
    {
        Gate::authorize('modules', 'post.catalouge.create');
        $listNode = $this->postCatalougeService->getToTree();
        $languages = Language::select('id', 'name')->get();

        return view('Backend.post.catalouge.create', [
            'listNode' => $listNode,
            'languages' => $languages
        ]);
    }

    public function store(StorePostCatalougeRequest $request)
    {
        Gate::authorize('modules', 'post.catalouge.create');
        if ($this->postCatalougeService->create($request)) {
            return redirect()->route('post.catalouge.index')->with('success', __('alert.addSuccess', ['attribute'=> __('custom.postGroup')]));
        }
        return redirect()->route('post.catalouge.index')->with('error', __('alert.addError', ['attribute'=> __('custom.postGroup')]));
    }

    public function edit($id)
    {
        Gate::authorize('modules', 'post.catalouge.update');
        $postCatalouge =$this->postCatalougeService->findById($id);

        $listNode = $this->postCatalougeService->getToTree($id);
        $languages = Language::select('id', 'name')->get();
        return view('backend.post.catalouge.create', [
            'listNode' => $listNode,
            'languages' => $languages,
            'postCatalouge' => $postCatalouge

        ]);
    }

    public function update($id, UpdatePostCatalougeRequest $request)
    {
        Gate::authorize('modules', 'post.catalouge.update');
        if ($this->postCatalougeService->update($id, $request)) {
            return redirect()->route('post.catalouge.index')->with('success', __('alert.updateSuccess', ['attribute'=> __('custom.postGroup')]));
        }

        return redirect()->route('post.catalouge.index')->with('error', __('alert.updateError', ['attribute'=> __('custom.postGroup')]));
    }

    public function delete($id)
    {
        Gate::authorize('modules', 'post.catalouge.delete');
        $postCatalouge =$this->postCatalougeService->findById($id);

        return view('backend.post.catalouge.delete', [
            'postCatalouge' => $postCatalouge
        ]);
    }

    public function destroy($id)
    {
        Gate::authorize('modules', 'post.catalouge.delete');
        if ($this->postCatalougeService->destroy($id)) {
            return redirect()->route('post.catalouge.index')->with('success', __('alert.deleteSuccess', ['attribute'=> __('custom.postGroup')]));
        }

        return redirect()->route('post.catalouge.index')->with('error', __('alert.deleteError', ['attribute'=> __('custom.postGroup')]));
    }
}
