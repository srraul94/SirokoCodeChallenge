<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'cart'], function () {
    Route::post('add/{productId}', [CartController::class, 'addToCart']);
    Route::put('update/{productId}', [CartController::class, 'updateCartItem']);
    Route::delete('remove/{productId}', [CartController::class, 'removeFromCart']);
    Route::get('total', [CartController::class, 'getTotalProductsInCart']);
    Route::post('confirm', [CartController::class, 'confirmCartPurchase']);
});
