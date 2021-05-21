<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user/me', function (Request $request) {
    return $request->user();
});

Route::prefix('store')->name('store.')->group(function(){
    Route::prefix('teams')->name('store.')->group(function(){
        Route::get('{id}/products', [\App\Http\Controllers\Store\TeamController::class, 'products']);
    });
    Route::resource('products', \App\Http\Controllers\Store\ProductController::class);
});
