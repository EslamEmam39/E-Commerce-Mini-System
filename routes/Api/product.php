<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;




Route::middleware('jwt')
->prefix('products')
->name('products.')
->controller(ProductController::class)
->group(function () {

    Route::get('/'        ,  'index')->name('index');
    Route::post('/'       ,  'store')->name('store');
    Route::put('/{id}'    ,  'update')->name('update');
    Route::delete('/{id}' ,  'destroy')->name('destroy');
});

