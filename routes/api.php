<?php

use App\Http\Controllers\OrderController;
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
