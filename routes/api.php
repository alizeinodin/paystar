<?php

use App\Http\Controllers\CreditCardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::middleware('auth:sanctum')->group(function () {

    Route::controller(OrderController::class)->group(function () {
        Route::prefix('/order')->group(function () {
            Route::name('order.')->group(function () {
                Route::post('/buy/{product}', 'buy')
                    ->name('buy');
                Route::post('/callback', 'callback')
                    ->name('callback');
            });
        });
    });

    Route::controller(CreditCardController::class)->group(function () {
        Route::prefix('/card')->group(function () {
            Route::name('card.')->group(function () {
                Route::get('/all', 'index')
                    ->name('all');
                Route::post('/store', 'store')
                    ->name('store');
            });
        });
    });

    Route::controller(ProductController::class)->group(function () {
        Route::prefix('/product')->group(function () {
            Route::name('product.')->group(function () {
                Route::get('/all', 'index')
                    ->name('all');
                Route::get('/{product}', 'get')
                    ->name('get');
            });
        });
    });

});
