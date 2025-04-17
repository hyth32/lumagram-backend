<?php

use Application\Interfaces\Controllers\ICommentController;
use Application\Interfaces\Controllers\ILikeController;
use Application\Interfaces\Controllers\IPostController;
use Illuminate\Support\Facades\Route;

Route::controller(IPostController::class)->middleware('auth:sanctum')->prefix('posts')->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/{post}', 'show');
    Route::delete('/{post}', 'destroy');
});

Route::controller(ILikeController::class)->middleware('auth:sanctum')->prefix('posts')->group(function () {
    Route::get('/{post}/likes', 'index');
    Route::put('/{post}/likes', 'toggle');
});

Route::controller(ICommentController::class)->middleware('auth:sanctum')->prefix('posts')->group(function () {
    Route::get('/{post}/comments', 'index');
    Route::post('/{post}/comments', 'store');
    Route::put('/{post}/comments/{comment}', 'update');
    Route::delete('/{post}/comments/{comment}', 'destroy');
});
