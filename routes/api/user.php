<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::controller(UserController::class)->middleware('auth:sanctum')->prefix('users')->group(function () {
    Route::put('/me', 'update');
    Route::get('/{user}/profile', 'profile');
    Route::get('/{user}/posts', 'getPosts');
});

Route::controller(UserController::class)->prefix('open')->group(function () {
    Route::get('/activities', 'activities');
});
