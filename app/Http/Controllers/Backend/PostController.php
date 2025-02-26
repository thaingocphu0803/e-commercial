<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Language;
use App\Services\PostService;
use Illuminate\Http\Request;

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
        // $posts = $this->postService->paginate($request);

        return view('Backend.post.post.index', [
            // 'posts' => $posts
        ]);
    }

    public function create()
    {
        $listNode = $this->postService->getToTree();
        $languages = Language::select('id', 'name')->get();

        return view('Backend.post.post.create', [
            'listNode' => $listNode,
            'languages' => $languages
        ]);
    }

    public function store(StorePostRequest $request)
    {

        if ($this->postService->create($request)) {
            return redirect()->route('post.index')->with('success', 'Added new post group successfully!');
        }
        return redirect()->route('post.index')->with('error', 'Failed to add new post group!');
    }

    public function edit($id)
    {
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
        if ($this->postService->update($id, $request)) {
            return redirect()->route('post.index')->with('success', 'Updated post group successfully!');
        }

        return redirect()->route('post.index')->with('error', 'Failed to updated post group!');
    }

    public function delete($id)
    {
        $post = $this->postService->findById($id);

        return view('backend.post.post.delete', [
            'post' => $post
        ]);
    }

    public function destroy($id)
    {
        if ($this->postService->destroy($id)) {
            return redirect()->route('post.index')->with('success', 'Deleted post group successfully!');
        }

        return redirect()->route('post.index')->with('error', 'Failed to delete post group!');
    }
}
