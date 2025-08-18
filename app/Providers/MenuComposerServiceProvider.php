<?php

namespace App\Providers;

use App\Http\ViewComposers\MenuComposer;
use Illuminate\Support\ServiceProvider;

class MenuComposerServiceProvider extends ServiceProvider
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
        view()->composer('components.frontend.dashboard.header.mainmenu', MenuComposer::class);

        view()->composer('components.frontend.dashboard.header', MenuComposer::class);
    }
}
