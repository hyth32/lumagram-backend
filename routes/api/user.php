<?php

use Illuminate\Support\Facades\Route;
use Application\Interfaces\Controllers\IUserController;

Route::controller(IUserController::class)->middleware('auth:sanctum')->prefix('users')->group(function () {
    Route::get('/me', 'me');
    Route::put('/me', 'update');
    Route::get('/{user}/profile', 'profile');
});