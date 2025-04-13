<?php

namespace Application\Providers;

use App\Http\Services\AuthService;
use App\Http\Services\CommentService;
use App\Http\Services\ImageService;
use App\Http\Services\LikeService;
use App\Http\Services\PostService;
use App\Http\Services\UserService;
use Illuminate\Support\ServiceProvider;
use Application\Interfaces\Services\IAuthService;
use Application\Interfaces\Services\ICommentService;
use Application\Interfaces\Services\IImageService;
use Application\Interfaces\Services\ILikeService;
use Application\Interfaces\Services\IPostService;
use Application\Interfaces\Services\IUserService;

class ServiceInterfaceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(IAuthService::class, AuthService::class);
        $this->app->bind(IUserService::class, UserService::class);
        $this->app->bind(IPostService::class, PostService::class);
        $this->app->bind(ILikeService::class, LikeService::class);
        $this->app->bind(ICommentService::class, CommentService::class);
        $this->app->bind(IImageService::class, ImageService::class);
    }

    public function boot(): void
    {
        //
    }
}
