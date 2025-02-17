<?php

use App\Http\Controllers\Ajax\DashboardController as AjaxDashboardController;
use App\Http\Controllers\Ajax\LocationController;
use App\Http\Controllers\Backend\AuthenController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\UserCatalougeController;
use App\Http\Controllers\Backend\UserController;
use Illuminate\Support\Facades\Route;

use function Pest\Laravel\delete;

Route::get('/', function () {
    return view('welcome');
});

// AuthenController
Route::get('/admin', [AuthenController::class, 'index'])->name('auth.admin')->middleware('login');
Route::post('/login', [AuthenController::class, 'login'])->name('auth.login');
Route::get('/logout', [AuthenController::class, 'logout'])->name('auth.logout');

// UserController

Route::controller(UserController::class)->middleware('admin')->prefix('user')->group(function () {
    Route::get('index',  'index')->name('user.index');
    Route::get('create', 'create')->name('user.create');
    Route::post('store', 'store')->name('user.store');
    Route::get('edit/{user}', 'edit')->name('user.edit');
    Route::post('update/{id}', 'update')->name('user.update');
    Route::get('delete/{user}', 'delete')->name('user.delete');
    Route::delete('destroy/{id}', 'destroy')->name('user.destroy');

});

//UserCatalougeController
Route::controller(UserCatalougeController::class)->middleware('admin')->prefix('user/catalouge')->group(function () {
    Route::get('index',  'index')->name('user.catalouge.index');
    Route::get('create', 'create')->name('user.catalouge.create');
    Route::post('store', 'store')->name('user.catalouge.store');
    Route::get('edit/{userCatalouge}', 'edit')->name('user.catalouge.edit');
    Route::post('update/{id}', 'update')->name('user.catalouge.update');
    Route::get('delete/{userCatalouge}', 'delete')->name('user.catalouge.delete');
    Route::delete('destroy/{id}', 'destroy')->name('user.catalouge.destroy');
});

// LocationController
Route::controller(LocationController::class)->prefix('ajax/location')->group(function(){
    Route::get('district', 'district')->name('location.district');
    Route::get('ward', 'ward')->name('location.ward');
});

//DashboardController
Route::controller(AjaxDashboardController::class)->prefix('ajax/dashboard')->middleware('admin')->group(function(){
    Route::post('changeStatus', 'changeStatus')->name('dashboard.changeStatus');
    Route::post('changeStatusAll', 'changeStatusAll')->name('dashboard.changeStatus');
});

// DashboardController
Route::get('/dashboard/index', [DashboardController::class, 'index'])->name('dashboard.index')->middleware('admin');
