//{ModuleName}Controller
Route::controller({ModuleName}Controller::class)->middleware(['admin', 'locale'])->prefix('{moduleRouterName}')->group(function () {
    Route::get('index',  'index')->name('{moduleViewName}.index');
    Route::get('create', 'create')->name('{moduleViewName}.create');
    Route::post('store', 'store')->name('{moduleViewName}.store');
    Route::get('edit/{id}', 'edit')->name('{moduleViewName}.edit');
    Route::post('update/{id}', 'update')->name('{moduleViewName}.update');
    Route::get('delete/{id}', 'delete')->name('{moduleViewName}.delete');
    Route::delete('destroy/{id}', 'destroy')->name('{moduleViewName}.destroy');
});
