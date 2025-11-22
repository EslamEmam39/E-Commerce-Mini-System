<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::controller(AuthController::class)->prefix('auth')->group(function () {

Route::post('/register', 'register');
Route::post('/login',  'login');

Route::middleware('jwt')->group(function () {
    Route::get('/me', 'getUser');
    Route::put('/me', 'updateUser');
    Route::post('/logout','logout');
});
});

Route::middleware('jwt')->get('/dashboard', [DashboardController::class, 'index']);





require __DIR__.'/Api/order.php';
require __DIR__.'/Api/product.php';
