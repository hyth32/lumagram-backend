<?php

namespace Application\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Application\Interfaces\Controllers\IAuthController;
use Application\Interfaces\Controllers\ICommentController;
use Application\Interfaces\Controllers\ILikeController;
use Application\Interfaces\Controllers\IPostController;
use Application\Interfaces\Controllers\IUserController;

class ControllerInterfaceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(IAuthController::class, AuthController::class);
        $this->app->bind(IUserController::class, UserController::class);
        $this->app->bind(IPostController::class, PostController::class);
        $this->app->bind(ILikeController::class, LikeController::class);
        $this->app->bind(ICommentController::class, CommentController::class);
    }

    public function boot(): void
    {
        //
    }
}
