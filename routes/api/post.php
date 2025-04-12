<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::controller(PostController::class)->prefix('posts')->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');

    Route::get('/{post}', 'show');
    Route::delete('/{post}', 'destroy');

    Route::post('/{post}/likes', 'like');
    Route::post('/{post}/comments', 'comment');
})->middleware('auth:sanctum');
