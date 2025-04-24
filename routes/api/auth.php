<?php

use Illuminate\Support\Facades\Route;
use Application\Interfaces\Controllers\IAuthController;

Route::controller(IAuthController::class)->prefix('auth')->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    
    Route::post('/forgot-password', 'forgotPassword');
    Route::post('/reset-password', 'resetPassword');
    
    Route::post('/refresh', 'refresh');
});

Route::controller(IAuthController::class)->middleware('auth:sanctum')->prefix('auth')->group(function () {
    Route::post('/logout', 'logout');
    
    Route::post('/change-password', 'changePassword');
});

Route::get('/csrf-token', function () {
    return [
        'csrf_token' => csrf_token(),
    ];
});

Route::get('/sanctum/csrf-cookie', function () {
    return response()->noContent();
});
