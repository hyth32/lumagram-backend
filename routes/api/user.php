<?php

use Illuminate\Support\Facades\Route;
use Application\Interfaces\Controllers\IUserController;

Route::controller(IUserController::class)->middleware('auth:sanctum')->prefix('users')->group(function () {
    Route::put('/me', 'update');
    Route::get('/{user}/profile', 'profile');
    Route::get('/{user}/posts', 'getPosts');
});

Route::controller(IUserController::class)->prefix('open')->group(function () {
    Route::get('/activities', 'activities');
});
