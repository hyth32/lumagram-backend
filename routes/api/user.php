<?php

use Illuminate\Support\Facades\Route;
use Application\Interfaces\Controllers\IUserController;

Route::controller(IUserController::class)->prefix('users')->group(function () {
    Route::get('/me', 'me');
    Route::put('/me', 'update');
    Route::get('/{user}/profile', 'profile');
})->middleware('auth:sanctum');
