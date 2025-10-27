<?php

namespace App\Providers;

use App\Models\Language;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class LanguageComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('components.backend.dashboard.sidebar', function ($view) {
            $languages = Language::where('publish', config('app.general.defaultPublish'))->get();
            $view->with('languages', $languages);
        });

        View::composer('components.frontend.dashboard.header', function ($view) {
            $languages = Language::where('publish', config('app.general.defaultPublish'))->get();
            $view->with('languages', $languages);
        });

        View::composer('components.frontend.dashboard.mobile.header', function ($view) {
            $languages = Language::where('publish', config('app.general.defaultPublish'))->get();
            $view->with('languages', $languages);
        });

        View::composer('components.frontend.dashboard.mobile.header', function ($view) {
            $languages = Language::all();
            $view->with('languages', $languages);
        });
    }
}
