<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::controller(PostController::class)->middleware('auth:sanctum')->group(function () {
    Route::prefix('posts')->group(function () {
        Route::post('/', 'store');
        Route::get('/{post}', 'show');
        Route::delete('/{post}', 'destroy');
    });

    Route::get('/feed', 'index');
});

Route::controller(LikeController::class)->middleware('auth:sanctum')->prefix('posts')->group(function () {
    Route::get('/{post}/likes', 'index');
    Route::put('/{post}/likes', 'toggle');
});

Route::controller(CommentController::class)->middleware('auth:sanctum')->prefix('posts')->group(function () {
    Route::get('/{post}/comments', 'index');
    Route::post('/{post}/comments', 'store');
});

Route::controller(CommentController::class)->middleware('auth:sanctum')->prefix('comments')->group(function () {
    Route::put('/{comment}', 'update');
    Route::delete('/{comment}', 'destroy');
});
