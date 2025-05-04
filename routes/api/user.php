<?php

use App\Http\Controllers\FollowController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::controller(UserController::class)->middleware('auth:sanctum')->prefix('users')->group(function () {
    Route::put('/profile', 'update');
    Route::put('/profile/change-username', 'updateUsername');
    Route::put('/profile/change-image', 'updateImage');

    Route::get('/{user}/profile', 'profile');
    Route::get('/{user}/posts', 'getPosts');

    Route::get('/check', 'check');
});

Route::controller(FollowController::class)->middleware('auth:sanctum')->prefix('users')->group(function () {
    Route::post('/{user}/follow', 'follow');
    Route::post('/{user}/unfollow', 'unfollow');

    Route::get('/{user}/followers', 'followers');
    Route::get('/{user}/following', 'following');
    
    Route::get('/follow-requests', 'followRequests');
    Route::post('/follow-requests/{user}', 'approveFollowRequest');
    Route::delete('/follow-requests/{user}', 'declineFollowRequest');
});

Route::controller(UserController::class)->prefix('open')->group(function () {
    Route::get('/activities', 'activities');
});
