<?php

namespace App\Providers;

use App\Http\ViewComposers\SystemComposer;
use Illuminate\Support\ServiceProvider;

class SystemComposerServiceProvider extends ServiceProvider
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
        view()->composer('components.frontend.dashboard.layout', SystemComposer::class);
    }
}
