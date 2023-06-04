<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::controller(OrderController::class)->group(function () {
    Route::prefix('/order')->group(function () {
        Route::name('order.')->group(function () {
            Route::post('/callback', 'callback')
                ->name('callback');
        });
    });
});

Route::get('/{path?}', function () {
    return view('home');
})
    ->where('path', '.*');
