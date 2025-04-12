<?php

namespace Application\Providers;

use App\Http\Services\AuthService;
use App\Http\Services\PostService;
use App\Http\Services\UserService;
use Illuminate\Support\ServiceProvider;
use Application\Interfaces\Services\IAuthService;
use Application\Interfaces\Services\IPostService;
use Application\Interfaces\Services\IUserService;

class ServiceInterfaceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(IAuthService::class, AuthService::class);
        $this->app->bind(IUserService::class, UserService::class);
        $this->app->bind(IPostService::class, PostService::class);
    }

    public function boot(): void
    {
        //
    }
}
