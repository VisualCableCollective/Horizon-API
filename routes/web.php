<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;

use App\Http\Controllers\VCCAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('auth')->name('auth.')->group(function(){
    Route::prefix('vcc')->name('vcc.')->group(function(){
        Route::get('redirect', [\App\Http\Controllers\Auth\WebAppAuthController::class, 'redirect']);
        Route::get('callback', [\App\Http\Controllers\Auth\WebAppAuthController::class, 'callback']);
    });
});

Broadcast::routes(['middleware' => ['auth:sanctum']]);
