<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\UserController;
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
Route::prefix('/auth')->group(function () {
    Route::controller(AuthController::class)->group(function() {
        Route::post('/login', 'login');
        Route::post('/register', 'register');

        Route::middleware(['auth:api'])->group(function () {
            Route::get('/user-detalis', 'userDetalis');
            Route::get('/refresh/token', 'refreshToken');
            Route::post('/logout', 'logout');
        });
    });
});

Route::middleware(['auth:api'])->group(function() {
    Route::prefix('/user')->group(function() {
        Route::controller(UserController::class)->group(function() {
            Route::get('/favorite-movies', 'favoriteMovies');
        });
    });
    Route::controller(MovieController::class)->group(function() {
        Route::apiResource('movies', MovieController::class);
        Route::prefix('/movies')->group(function() {
            Route::post('/{movie}/follow', 'follow');
        });
    });

});
