<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostCatalougeRequest;
use App\Http\Requests\UpdatePostCatalougeRequest;
use App\Models\Language;
use App\Models\PostCatalouge;
use App\Services\PostCatalougeService;
use Illuminate\Http\Request;

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
        $postCatalouges = $this->postCatalougeService->paginate($request);
        return view('Backend.post.catalouge.index', [
            'postCatalouges' => $postCatalouges
        ]);
    }

    public function create()
    {
        $listNode = $this->postCatalougeService->getToTree();
        $languages = Language::select('id', 'name')->get();

        return view('Backend.post.catalouge.create', [
            'listNode' => $listNode,
            'languages' => $languages
        ]);
    }

    public function store(StorePostCatalougeRequest $request)
    {
        if ($this->postCatalougeService->create($request)) {
            return redirect()->route('post.catalouge.index')->with('success', 'Added new post group successfully!');
        }
        return redirect()->route('post.catalouge.index')->with('error', 'Failed to add new post group!');
    }

    public function edit(PostCatalouge $postCatalouge)
    {
        return view('backend.post.catalouge.create', [
            'postCatalouge' => $postCatalouge
        ]);
    }

    public function update($id, UpdatePostCatalougeRequest $request)
    {

        if ($this->postCatalougeService->update($id, $request)) {
            return redirect()->route('post.catalouge.index')->with('success', 'Updated post group successfully!');
        }

        return redirect()->route('post.catalouge.index')->with('error', 'Failed to updated post group!');
    }

    public function delete(PostCatalouge $postCatalouge)
    {
        return view('backend.post.catalouge.delete', [
            'post group' => $postCatalouge
        ]);
    }

    public function destroy($id)
    {
        if ($this->postCatalougeService->destroy($id)) {
            return redirect()->route('post.catalouge.index')->with('success', 'Deleted post group successfully!');
        }

        return redirect()->route('post.catalouge.index')->with('error', 'Failed to delete post group!');
    }
}
