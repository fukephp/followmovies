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
            Route::get('/movies', 'movies');
            Route::post('/movies/{movie}/follow', 'followMovie');
            Route::post('/movies/{movie}/unfollow', 'unfollowMovie');
        });
    });
    Route::apiResource('movies', MovieController::class);
});
