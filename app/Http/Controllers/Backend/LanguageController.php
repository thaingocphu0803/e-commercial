<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLanguageRequest;
use App\Http\Requests\UpdateLanguageRequest;
use App\Models\Language;
use App\Services\LanguageService;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    protected $languageService;

    public function __construct(
        LanguageService $languageService,
    ) {
        $this->languageService = $languageService;
    }

    public function index(Request $request)
    {
        $languages = $this->languageService->paginate($request);
        return view('Backend.language.index', [
            'languages' => $languages
        ]);
    }

    public function create()
    {
        return view('Backend.language.create');
    }

    public function store(StoreLanguageRequest $request)
    {
        if ($this->languageService->create($request)) {
            return redirect()->route('language.index')->with('success', 'Added new language successfully!');
        }
        return redirect()->route('language.index')->with('error', 'Failed to add new language!');
    }

    public function edit(Language $language)
    {
        return view('backend.language.create', [
            'language' => $language
        ]);
    }

    public function update($id, UpdateLanguageRequest $request)
    {

        if ($this->languageService->update($id, $request)) {
            return redirect()->route('language.index')->with('success', 'Updated language successfully!');
        }

        return redirect()->route('language.index')->with('error', 'Failed to updated language!');
    }

    public function delete(Language $language)
    {
        return view('backend.language.delete', [
            'language' => $language
        ]);
    }

    public function destroy($id)
    {
        if ($this->languageService->destroy($id)) {
            return redirect()->route('language.index')->with('success', 'Deleted language successfully!');
        }

        return redirect()->route('language.index')->with('error', 'Failed to delete language!');
    }
}
