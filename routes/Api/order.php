<?php

use App\Http\Controllers\Api\OrderController;
use Illuminate\Support\Facades\Route;



Route::middleware('jwt')->prefix('orders')->group(function () {

 Route::post('/', [OrderController::class, 'store']);

});
