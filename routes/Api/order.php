<?php

use App\Http\Controllers\Api\OrderController;
use Illuminate\Support\Facades\Route;



Route::middleware('jwt')
->prefix('orders')
->name('orders.')
->controller(OrderController::class)
->group(function () {

 Route::get( '/',  'index')->name('index');
 Route::post('/', 'store')->name('store');
 Route::get('/{id}', 'show')->name('show');

});
