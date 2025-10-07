<?php

use App\Http\Controllers\Ajax\AttrController as AjaxAttrController;
use App\Http\Controllers\Ajax\CartController as AjaxCartController;
use App\Http\Controllers\Ajax\DashboardController as AjaxDashboardController;
use App\Http\Controllers\Ajax\LocationController;
use App\Http\Controllers\Ajax\MenuController as AjaxMenuController;
use App\Http\Controllers\Ajax\ProductController as AjaxProductController;
use App\Http\Controllers\Ajax\PromotionController as AjaxPromotionController;
use App\Http\Controllers\Backend\AuthenController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\GenerateController;
use App\Http\Controllers\Backend\LanguageController;
use App\Http\Controllers\Backend\PostCatalougeController;
use App\Http\Controllers\Backend\PostController;
use App\Http\Controllers\Backend\UserCatalougeController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\PermissionController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProductCatalougeController;
use App\Http\Controllers\Backend\AttrController;
use App\Http\Controllers\Backend\AttrCatalougeController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\CustomerCatalougeController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\MenuController;
use App\Http\Controllers\Backend\PromotionController;
use App\Http\Controllers\Backend\SlideController;
use App\Http\Controllers\Backend\SourceController;
use App\Http\Controllers\Backend\SystemController;
use App\Http\Controllers\Fontend\ProductController as FontendProductController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\RouterController;
use Cloudinary\Transformation\Rotate;

/** FONTEND ROUTES */

// HomeController
Route::get('/', [HomeController::class, 'index'])->name('home.index')->middleware('locale');

// CartController
Route::get('payment', [CartController::class, 'index'])->name('cart.index')->middleware('locale');


// RouteController
Route::get('{canonical}'. config('app.general.suffix'), [RouterController::class, 'index'])->name('router.index')->where('canonical', '[a-zA-z0-9-]+');

// Ajax ProductController
Route::controller(AjaxProductController::class)->prefix('ajax/product')->middleware(['locale'])->group(function(){
    Route::get('loadProductWithVariant', 'loadProductWithVariant')->name('product.loadProductWithVariant');
    Route::get('loadProductByVariant', 'loadProductByVariant')->name('product.loadProductByVariant');

});

// Ajax CartController
Route::controller(AjaxCartController::class)->prefix('ajax/cart')->middleware(['locale'])->group(function(){
    Route::post('create', 'create')->name('ajax.cart.create');
});

//LanguageController
Route::controller(LanguageController::class)->middleware(['locale'])->prefix('home/language')->group(function () {
    Route::get('change/{canonical}', 'changeCurrent')->name('home.language.change');
});

/*********************************************************************************************************************************************************/

/** BACKEND ROUTES */

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

// CustomerController
Route::controller(CustomerController::class)->middleware(['admin', 'locale'])->prefix('customer')->group(function () {
    Route::get('index',  'index')->name('customer.index');
    Route::get('create', 'create')->name('customer.create');
    Route::post('store', 'store')->name('customer.store');
    Route::get('edit/{customer}', 'edit')->name('customer.edit');
    Route::post('update/{id}', 'update')->name('customer.update');
    Route::get('delete/{customer}', 'delete')->name('customer.delete');
    Route::delete('destroy/{id}', 'destroy')->name('customer.destroy');

});

//CustomerCatalougeController
Route::controller(CustomerCatalougeController::class)->middleware(['admin', 'locale'])->prefix('customer/catalouge')->group(function () {
    Route::get('index',  'index')->name('customer.catalouge.index');
    Route::get('create', 'create')->name('customer.catalouge.create');
    Route::post('store', 'store')->name('customer.catalouge.store');
    Route::get('edit/{customerCatalouge}', 'edit')->name('customer.catalouge.edit');
    Route::post('update/{id}', 'update')->name('customer.catalouge.update');
    Route::get('delete/{customerCatalouge}', 'delete')->name('customer.catalouge.delete');
    Route::delete('destroy/{id}', 'destroy')->name('customer.catalouge.destroy');
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


//GenerateController
Route::controller(GenerateController::class)->middleware(['admin', 'locale'])->prefix('generate')->group(function () {
    Route::get('index',  'index')->name('generate.index');
    Route::get('create', 'create')->name('generate.create');
    Route::post('store', 'store')->name('generate.store');
    Route::get('edit/{generate}', 'edit')->name('generate.edit');
    Route::post('update/{id}', 'update')->name('generate.update');
    Route::get('delete/{generate}', 'delete')->name('generate.delete');
    Route::delete('destroy/{id}', 'destroy')->name('generate.destroy');
});

//SystemController
Route::controller(SystemController::class)->middleware(['admin', 'locale'])->prefix('system')->group(function () {
    Route::get('index',  'index')->name('system.index');
    Route::post('store', 'store')->name('system.store');
});

//MenuController
Route::controller(MenuController::class)->middleware(['admin', 'locale'])->prefix('menu')->group(function () {
    Route::get('index',  'index')->name('menu.index');
    Route::get('create', 'create')->name('menu.create');
    Route::post('store', 'store')->name('menu.store');
    Route::get('edit/{id}', 'edit')->name('menu.edit');
    Route::get('delete/{menuCatalouge}', 'delete')->name('menu.delete');
    Route::delete('destroy/{id}', 'destroy')->name('menu.destroy');
    Route::get('{id}/child', 'childIndex')->name('menu.child.index');
    Route::get('edit/{id}/parentMenu', 'editParentMenu')->name('menu.edit.parentMenu');
    Route::post('{parent_id}/childSave', 'childSave')->name('menu.child.save');
    Route::post('{menu_catalouge_id}/parentSave', 'parentSave')->name('menu.parent.save');


});

//SlideController
Route::controller(SlideController::class)->middleware(['admin', 'locale'])->prefix('slide')->group(function () {
    Route::get('index',  'index')->name('slide.index');
    Route::get('create', 'create')->name('slide.create');
    Route::post('store', 'store')->name('slide.store');
    Route::get('edit/{slide}', 'edit')->name('slide.edit');
    Route::post('update/{id}', 'update')->name('slide.update');
    Route::get('delete/{slide}', 'delete')->name('slide.delete');
    Route::delete('destroy/{id}', 'destroy')->name('slide.destroy');
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

//ProductController
Route::controller(ProductController::class)->middleware(['admin', 'locale'])->prefix('product')->group(function () {
    Route::get('index',  'index')->name('product.index');
    Route::get('create', 'create')->name('product.create');
    Route::post('store', 'store')->name('product.store');
    Route::get('edit/{id}', 'edit')->name('product.edit');
    Route::post('update/{id}', 'update')->name('product.update');
    Route::get('delete/{id}', 'delete')->name('product.delete');
    Route::delete('destroy/{id}', 'destroy')->name('product.destroy');
});
//ProductCatalougeController
Route::controller(ProductCatalougeController::class)->middleware(['admin', 'locale'])->prefix('product/catalouge')->group(function () {
    Route::get('index',  'index')->name('product.catalouge.index');
    Route::get('create', 'create')->name('product.catalouge.create');
    Route::post('store', 'store')->name('product.catalouge.store');
    Route::get('edit/{id}', 'edit')->name('product.catalouge.edit');
    Route::post('update/{id}', 'update')->name('product.catalouge.update');
    Route::get('delete/{id}', 'delete')->name('product.catalouge.delete');
    Route::delete('destroy/{id}', 'destroy')->name('product.catalouge.destroy');
});
//PromotionController
Route::controller(PromotionController::class)->middleware(['admin', 'locale'])->prefix('promotion')->group(function () {
    Route::get('index',  'index')->name('promotion.index');
    Route::get('create', 'create')->name('promotion.create');
    Route::post('store', 'store')->name('promotion.store');
    Route::get('edit/{id}', 'edit')->name('promotion.edit');
    Route::post('update/{id}', 'update')->name('promotion.update');
    Route::get('delete/{id}', 'delete')->name('promotion.delete');
    Route::delete('destroy/{id}', 'destroy')->name('promotion.destroy');
});
//CouponController
Route::controller(CouponController::class)->middleware(['admin', 'locale'])->prefix('coupon')->group(function () {
    Route::get('index',  'index')->name('coupon.index');
    Route::get('create', 'create')->name('coupon.create');
    Route::post('store', 'store')->name('coupon.store');
    Route::get('edit/{id}', 'edit')->name('coupon.edit');
    Route::post('update/{id}', 'update')->name('coupon.update');
    Route::get('delete/{id}', 'delete')->name('coupon.delete');
    Route::delete('destroy/{id}', 'destroy')->name('coupon.destroy');
});

//SouceController
Route::controller(SourceController::class)->middleware(['admin', 'locale'])->prefix('source')->group(function () {
    Route::get('index',  'index')->name('source.index');
    Route::get('create', 'create')->name('source.create');
    Route::post('store', 'store')->name('source.store');
    Route::get('edit/{id}', 'edit')->name('source.edit');
    Route::post('update/{id}', 'update')->name('source.update');
    Route::get('delete/{id}', 'delete')->name('source.delete');
    Route::delete('destroy/{id}', 'destroy')->name('source.destroy');
});

//AttrController
Route::controller(AttrController::class)->middleware(['admin', 'locale'])->prefix('attr')->group(function () {
    Route::get('index',  'index')->name('attr.index');
    Route::get('create', 'create')->name('attr.create');
    Route::post('store', 'store')->name('attr.store');
    Route::get('edit/{id}', 'edit')->name('attr.edit');
    Route::post('update/{id}', 'update')->name('attr.update');
    Route::get('delete/{id}', 'delete')->name('attr.delete');
    Route::delete('destroy/{id}', 'destroy')->name('attr.destroy');
});
//AttrCatalougeController
Route::controller(AttrCatalougeController::class)->middleware(['admin', 'locale'])->prefix('attr/catalouge')->group(function () {
    Route::get('index',  'index')->name('attr.catalouge.index');
    Route::get('create', 'create')->name('attr.catalouge.create');
    Route::post('store', 'store')->name('attr.catalouge.store');
    Route::get('edit/{id}', 'edit')->name('attr.catalouge.edit');
    Route::post('update/{id}', 'update')->name('attr.catalouge.update');
    Route::get('delete/{id}', 'delete')->name('attr.catalouge.delete');
    Route::delete('destroy/{id}', 'destroy')->name('attr.catalouge.destroy');
});
//@new-module@

//Ajax DashboardController
Route::controller(AjaxDashboardController::class)->prefix('ajax/dashboard')->middleware(['admin', 'locale'])->group(function(){
    Route::post('changeStatus', 'changeStatus')->name('dashboard.changeStatus');
    Route::post('changeStatusAll', 'changeStatusAll')->name('dashboard.changeStatus');
    Route::post('upload/image', 'uploadImage')->name('dashboard.upload.image');
    Route::get('getMenu', 'getMenu')->name('dashboard.getMenu');
});

//Ajax ProductController
Route::controller(AjaxProductController::class)->prefix('ajax/product')->middleware(['admin', 'locale'])->group(function(){
    Route::get('loadProductPromotion', 'loadProductPromotion')->name('product.loadProductPromotion');
    Route::get('loadProductCatalougePromotion', 'loadProductCatalougePromotion')->name('product.loadProductCatalougePromotion');
});

//Ajax PromotionController
Route::controller(AjaxPromotionController::class)->prefix('ajax/promotion')->middleware(['admin', 'locale'])->group(function(){
    Route::get('loadCustomerPromotionType', 'loadCustomerPromotionType')->name('product.loadCustomerPromotionType');
});

//Ajax AttrController
Route::controller(AjaxAttrController::class)->prefix('ajax/attr')->middleware(['admin', 'locale'])->group(function(){
    Route::get('getAttr', 'getAttr')->name('attr.getAttr');
    Route::get('loadAttr', 'loadAttr')->name('attr.loadAttr');

});

//Ajax MenuController
Route::controller(AjaxMenuController::class)->prefix('ajax/menu')->middleware(['admin', 'locale'])->group(function(){
    Route::post('createCatalouge', 'createCatalouge')->name('menu.createCatalouge');
    Route::post('dragDrop', 'dragDrop')->name('menu.dragDrop');
});

// DashboardController
Route::get('/dashboard/index', [DashboardController::class, 'index'])->name('dashboard.index')->middleware(['admin', 'locale']);
