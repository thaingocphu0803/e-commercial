<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        'App\Repositories\Interfaces\UserRepositoryInterface' => 'App\Repositories\UserRepository',

        'App\Repositories\Interfaces\DistrictProvinceRepositoryInterface' => 'App\Repositories\DistrictRepository',

        'App\Repositories\Interfaces\ProvinceRepositoryInterface' => 'App\Repositories\ProvinceRepository',

        'App\Repositories\Interfaces\WardRepositoryInterface' => 'App\Repositories\WardRepository',

        'App\Repositories\Interfaces\UserCatalougeRepositoryInterface' => 'App\Repositories\UserCatalougeRepository',
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        foreach ($this->bindings as $interface => $implementation){
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
