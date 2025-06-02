<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Language;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    protected $postService;

    public function __construct(
        PostService $postService,
    ) {
        $this->postService = $postService;
    }

    public function index(Request $request)
    {
        Gate::authorize('modules', 'post.index');
        $posts = $this->postService->paginate($request);
        $listNode = $this->postService->getToTree();

        return view('Backend.post.post.index', [
            'posts' => $posts,
            'listNode' => $listNode,
        ]);
    }

    public function create()
    {
        Gate::authorize('modules', 'post.create');
        $listNode = $this->postService->getToTree();
        $languages = Language::select('id', 'name')->get();

        return view('Backend.post.post.create', [
            'listNode' => $listNode,
            'languages' => $languages
        ]);
    }

    public function store(StorePostRequest $request)
    {
        Gate::authorize('modules', 'post.create');
        if ($this->postService->create($request)) {
            return redirect()->route('post.index')->with('success',  __('alert.addSuccess', ['attribute'=> __('custom.post')]));
        }
        return redirect()->route('post.index')->with('error',  __('alert.addError', ['attribute'=> __('custom.post')]));
    }

    public function edit($id)
    {
        Gate::authorize('modules', 'post.update');
        $post = $this->postService->findById($id);
        $listNode = $this->postService->getToTree();
        $languages = Language::select('id', 'name')->get();

        return view('backend.post.post.create', [
            'listNode' => $listNode,
            'languages' => $languages,
            'post' => $post

        ]);
    }

    public function update($id, UpdatePostRequest $request)
    {
        Gate::authorize('modules', 'post.update');
        if ($this->postService->update($id, $request)) {
            return redirect()->route('post.index')->with('success',  __('alert.updateSuccess', ['attribute'=> __('custom.post')]));
        }

        return redirect()->route('post.index')->with('error',  __('alert.updateError', ['attribute'=> __('custom.post')]));
    }

    public function delete($id)
    {
        Gate::authorize('modules', 'post.delete');
        $post = $this->postService->findById($id);

        return view('backend.post.post.delete', [
            'post' => $post
        ]);
    }

    public function destroy($id)
    {
        Gate::authorize('modules', 'post.delete');
        if ($this->postService->destroy($id)) {
            return redirect()->route('post.index')->with('success',  __('alert.deleteSuccess', ['attribute'=> __('custom.post')]));
        }

        return redirect()->route('post.index')->with('error',  __('alert.deleteError', ['attribute'=> __('custom.post')]));
    }
}
