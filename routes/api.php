<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\CustomerController;
use App\Http\Controllers\api\CompanyController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\CartController;
use App\Http\Controllers\api\OrderController;


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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('customer')->group(function () {
Route::controller(CustomerController::class)->group(function () {
    Route::get('/show', 'index');
    Route::post('/store', 'store');
    Route::put('/update/{id}', 'update');
    Route::get('/search/{id}', 'show');
    Route::delete('/delete/{id}', 'destroy');
    Route::put('/restore', 'restore');
});
});


Route::prefix('/company')->group(function () {
    Route::controller(CompanyController::class)->group(function () {
        Route::get('/index', 'index');
        Route::post('/store', 'store');
        Route::get('/search/{id}', 'show');
        Route::put('/update/{id}', 'update');
        Route::delete('/delete/{id}', 'destroy');
    });
});

Route::prefix('/product')->group(function () {
    Route::controller(ProductController::class)->group(function () {
        Route::get('/index','index');
        Route::get('/search', 'show');
        Route::post('/store', 'store');
        Route::put('/update', 'update');
        Route::delete('/delete', 'destroy');

    });

});
Route::prefix('cart')->group(function () {
    Route::controller(CartController::class)->group(function () {
        Route::get('/index', 'index');
        Route::post('/store', 'store');
        Route::put('/update', 'update');
        Route::delete('/delete', 'destroy');
    });
});

Route::prefix('order')->group(function () {
    Route::controller(OrderController::class)->group(function () {
        Route::get('/index', 'index');
        Route::get('/details', 'details');
        Route::post('/store', 'create');
        Route::put('/update', 'update');
        Route::delete('/delete', 'destroy');
    });
});
