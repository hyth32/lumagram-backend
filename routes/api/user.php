<?php

use Illuminate\Support\Facades\Route;
use Application\Interfaces\Controllers\IUserController;

Route::controller(IUserController::class)->prefix('users')->group(function () {
    Route::put('/profile', 'update');
    Route::get('/{user}/profile', 'profile');
})->middleware('auth:sanctum');
