<?php

use Illuminate\Support\Facades\Route;
use Application\Interfaces\Controllers\IAuthController;
use Application\Interfaces\Controllers\IUserController;

/**
 * Auth
 */
Route::controller(IAuthController::class)->prefix('auth')->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    
    Route::post('/forgot-password', 'forgotPassword');
    Route::post('/reset-password', 'resetPassword');
    
    Route::post('/refresh', 'refresh');
});

Route::controller(IAuthController::class)->prefix('auth')->group(function () {
    Route::post('/logout', 'logout');
})->middleware('auth:sanctum');

/**
 * User
 */
Route::controller(IUserController::class)->prefix('users')->group(function () {
    Route::get('/me', 'me');
    Route::post('/profile/update', 'update');
    Route::get('/{user}/profile', 'profile');
})->middleware('auth:sanctum');
