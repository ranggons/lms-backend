<?php

use App\Http\Controllers\API\Rangon\AuthenticationController;
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

Route::prefix('auth')->controller(AuthenticationController::class)->group(function () {
    Route::post('login', 'login')->name('login');
    Route::middleware(['api', 'auth:sanctum'])->group(function () {
        Route::post('logout', 'logout')->name('logout');
    });
});
