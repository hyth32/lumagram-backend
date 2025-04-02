<?php

use Illuminate\Support\Facades\Route;
use Application\Interfaces\Controllers\IAuthController;

Route::controller(IAuthController::class)->prefix('auth')->group(function () {
    Route::post('/register', 'register');

    Route::post('/login', 'login');

    Route::post('/refresh', 'refresh');
});

Route::controller(IAuthController::class)->prefix('auth')->group(function () {
    Route::post('/logout', 'logout');

    Route::post('/reset-password', 'resetPassword');
})->middleware('auth:sanctum');
