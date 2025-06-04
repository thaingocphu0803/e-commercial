<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        'App\Repositories\Interfaces\UserRepositoryInterface' => 'App\Repositories\UserRepository',

        'App\Repositories\Interfaces\DistrictProvinceRepositoryInterface' => 'App\Repositories\DistrictRepository',

        'App\Repositories\Interfaces\ProvinceRepositoryInterface' => 'App\Repositories\ProvinceRepository',

        'App\Repositories\Interfaces\WardRepositoryInterface' => 'App\Repositories\WardRepository',

        'App\Repositories\Interfaces\UserCatalougeRepositoryInterface' => 'App\Repositories\UserCatalougeRepository',

        'App\Repositories\Interfaces\LanguageRepositoryInterface' => 'App\Repositories\LanguageRepository',

        'App\Repositories\Interfaces\PostCatalougeRepositoryInterface' => 'App\Repositories\PostCatalougeRepository',

        'App\Repositories\Interfaces\PostRepositoryInterface' => 'App\Repositories\PostRepository',

        'App\Repositories\Interfaces\RouterRepositoryInterface' => 'App\Repositories\RouterRepository',

        'App\Repositories\Interfaces\PermissionRepositoryInterface' => 'App\Repositories\PermissionRepository',

        'App\Repositories\Interfaces\GenerateRepositoryInterface' => 'App\Repositories\GenerateRepository',

    	"App\Repositories\Interfaces\ProductCatalougeRepositoryInterface" => "App\Repositories\ProductCatalougeRepository",

		"App\Repositories\Interfaces\ProductRepositoryInterface" => "App\Repositories\ProductRepository",

		"App\Repositories\Interfaces\AttrCatalougeRepositoryInterface" => "App\Repositories\AttrCatalougeRepository",

		"App\Repositories\Interfaces\AttrRepositoryInterface" => "App\Repositories\AttrRepository",

        "App\Repositories\Interfaces\ProductVariantAttrRepositoryInterface" => "App\Repositories\ProductVariantAttrRepository",

        "App\Repositories\Interfaces\ProductVariantRepositoryInterface" => "App\Repositories\ProductVariantRepository",

		"App\Repositories\Interfaces\SystemRepositoryInterface" => "App\Repositories\SystemRepository",

        "App\Repositories\Interfaces\MenuRepositoryInterface" => "App\Repositories\MenuRepository",

        "App\Repositories\Interfaces\MenuCatalougeRepositoryInterface" => "App\Repositories\MenuCatalougeRepository",

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
        Gate::define('modules', function($user, $permissionName){
            if($user->publish == 2){
                return false;
            }

            $permission = $user->userCatalouge->permissions;
            if ($permission->contains('canonical', $permissionName)){
                return true;
            }

            return false;
        });
    }
}
