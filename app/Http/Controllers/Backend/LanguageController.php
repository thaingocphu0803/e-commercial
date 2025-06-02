<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLanguageRequest;
use App\Http\Requests\UpdateLanguageRequest;
use App\Models\Language;
use App\Services\LanguageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;

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
        Gate::authorize('modules', 'language.index');
        $languages = $this->languageService->paginate($request);
        return view('Backend.language.index', [
            'languages' => $languages
        ]);
    }

    public function create()
    {
        Gate::authorize('modules', 'language.create');
        return view('Backend.language.create');
    }

    public function store(StoreLanguageRequest $request)
    {
        Gate::authorize('modules', 'language.create');
        if ($this->languageService->create($request)) {
            return redirect()->route('language.index')->with('success', __('alert.addSuccess', ['attribute'=> __('custom.language')]));
        }
        return redirect()->route('language.index')->with('error', __('alert.addError', ['attribute'=> __('custom.language')]));
    }

    public function edit(Language $language)
    {
        Gate::authorize('modules', 'language.update');
        return view('backend.language.create', [
            'language' => $language
        ]);
    }

    public function update($id, UpdateLanguageRequest $request)
    {
        Gate::authorize('modules', 'language.update');
        if ($this->languageService->update($id, $request)) {
            return redirect()->route('language.index')->with('success', __('alert.updateSuccess', ['attribute'=> __('custom.language')]));
        }

        return redirect()->route('language.index')->with('error', __('alert.updateError', ['attribute'=> __('custom.language')]));
    }

    public function delete(Language $language)
    {
        Gate::authorize('modules', 'language.delete');
        return view('backend.language.delete', [
            'language' => $language
        ]);
    }

    public function destroy($id)
    {
        Gate::authorize('modules', 'language.delete');
        if ($this->languageService->destroy($id)) {
            return redirect()->route('language.index')->with('success', __('alert.deleteSuccess', ['attribute'=> __('custom.language')]));
        }

        return redirect()->route('language.index')->with('error', __('alert.deleteError', ['attribute'=> __('custom.language')]));
    }

    public function changeCurrent($canonical){

        if($this->languageService->changeCurrent($canonical))
        {

            session([
                'app_locale' => $canonical
            ]);

        }
        return back();

    }
}
