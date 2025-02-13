<?php

use App\Http\Controllers\Ajax\LocationController;
use App\Http\Controllers\Backend\AuthenController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Middleware\AuthenticateMiddleware;
use Illuminate\Support\Facades\Route;

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
});

// AjaxController
Route::controller(LocationController::class)->prefix('ajax/location')->group(function(){
    Route::get('district', 'district')->name('location.district');
    Route::get('ward', 'ward')->name('location.ward');
});



// DashboardController
Route::get('/dashboard/index', [DashboardController::class, 'index'])->name('dashboard.index')->middleware('admin');
