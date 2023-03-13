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
    Route::post('forgot-password', 'forgotPassword')->name('password.request');
    Route::post('reset-password', 'resetPassword')->name('password.reset');

    Route::middleware(['api', 'auth:sanctum'])->group(function () {
        Route::post('logout', 'logout')->name('logout');
    });
});

Route::prefix('rangon')->group(base_path('routes/rangon.php'));

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
