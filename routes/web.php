<?php

use App\Http\Controllers\Ajax\DashboardController as AjaxDashboardController;
use App\Http\Controllers\Ajax\LocationController;
use App\Http\Controllers\Backend\AuthenController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\LanguageController;
use App\Http\Controllers\Backend\PostCatalougeController;
use App\Http\Controllers\Backend\PostController;
use App\Http\Controllers\Backend\UserCatalougeController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Route;

use function Pest\Laravel\delete;

Route::get('/', function () {
    return view('welcome');
});

// AuthenController
Route::get('/admin', [AuthenController::class, 'index'])->name('auth.admin')->middleware(['login', 'locale']);
Route::post('/login', [AuthenController::class, 'login'])->name('auth.login');
Route::get('/logout', [AuthenController::class, 'logout'])->name('auth.logout');

// UserController

Route::controller(UserController::class)->middleware(['admin', 'locale'])->prefix('user')->group(function () {
    Route::get('index',  'index')->name('user.index');
    Route::get('create', 'create')->name('user.create');
    Route::post('store', 'store')->name('user.store');
    Route::get('edit/{user}', 'edit')->name('user.edit');
    Route::post('update/{id}', 'update')->name('user.update');
    Route::get('delete/{user}', 'delete')->name('user.delete');
    Route::delete('destroy/{id}', 'destroy')->name('user.destroy');

});

//UserCatalougeController
Route::controller(UserCatalougeController::class)->middleware(['admin', 'locale'])->prefix('user/catalouge')->group(function () {
    Route::get('index',  'index')->name('user.catalouge.index');
    Route::get('create', 'create')->name('user.catalouge.create');
    Route::post('store', 'store')->name('user.catalouge.store');
    Route::get('edit/{userCatalouge}', 'edit')->name('user.catalouge.edit');
    Route::post('update/{id}', 'update')->name('user.catalouge.update');
    Route::get('delete/{userCatalouge}', 'delete')->name('user.catalouge.delete');
    Route::delete('destroy/{id}', 'destroy')->name('user.catalouge.destroy');
    Route::get('permission', 'permission')->name('user.catalouge.permission');
    Route::post('updatePermission', 'updatePermission')->name('user.catalouge.updatePermission');

});

// LocationController
Route::controller(LocationController::class)->prefix('ajax/location')->group(function(){
    Route::get('district', 'district')->name('location.district');
    Route::get('ward', 'ward')->name('location.ward');
});

//LanguageController
Route::controller(LanguageController::class)->middleware(['admin', 'locale'])->prefix('language')->group(function () {
    Route::get('index',  'index')->name('language.index');
    Route::get('create', 'create')->name('language.create');
    Route::post('store', 'store')->name('language.store');
    Route::get('edit/{language}', 'edit')->name('language.edit');
    Route::post('update/{id}', 'update')->name('language.update');
    Route::get('delete/{language}', 'delete')->name('language.delete');
    Route::delete('destroy/{id}', 'destroy')->name('language.destroy');
    Route::get('change/{canonical}', 'changeCurrent')->name('language.change');

});

//PermissionController
Route::controller(PermissionController::class)->middleware(['admin', 'locale'])->prefix('permission')->group(function () {
    Route::get('index',  'index')->name('permission.index');
    Route::get('create', 'create')->name('permission.create');
    Route::post('store', 'store')->name('permission.store');
    Route::get('edit/{permission}', 'edit')->name('permission.edit');
    Route::post('update/{id}', 'update')->name('permission.update');
    Route::get('delete/{permission}', 'delete')->name('permission.delete');
    Route::delete('destroy/{id}', 'destroy')->name('permission.destroy');
});

//PostController
Route::controller(PostController::class)->middleware(['admin', 'locale'])->prefix('post')->group(function () {
    Route::get('index',  'index')->name('post.index');
    Route::get('create', 'create')->name('post.create');
    Route::post('store', 'store')->name('post.store');
    Route::get('edit/{id}', 'edit')->name('post.edit');
    Route::post('update/{id}', 'update')->name('post.update');
    Route::get('delete/{id}', 'delete')->name('post.delete');
    Route::delete('destroy/{id}', 'destroy')->name('post.destroy');
});

//PostCatalougeController
Route::controller(PostCatalougeController::class)->middleware(['admin', 'locale'])->prefix('post/catalouge')->group(function () {
    Route::get('index',  'index')->name('post.catalouge.index');
    Route::get('create', 'create')->name('post.catalouge.create');
    Route::post('store', 'store')->name('post.catalouge.store');
    Route::get('edit/{id}', 'edit')->name('post.catalouge.edit');
    Route::post('update/{id}', 'update')->name('post.catalouge.update');
    Route::get('delete/{id}', 'delete')->name('post.catalouge.delete');
    Route::delete('destroy/{id}', 'destroy')->name('post.catalouge.destroy');
});

//DashboardController
Route::controller(AjaxDashboardController::class)->prefix('ajax/dashboard')->middleware(['admin', 'locale'])->group(function(){
    Route::post('changeStatus', 'changeStatus')->name('dashboard.changeStatus');
    Route::post('changeStatusAll', 'changeStatusAll')->name('dashboard.changeStatus');
    Route::post('upload/image', 'uploadImage')->name('dashboard.upload.image');

});

// DashboardController
Route::get('/dashboard/index', [DashboardController::class, 'index'])->name('dashboard.index')->middleware(['admin', 'locale']);
