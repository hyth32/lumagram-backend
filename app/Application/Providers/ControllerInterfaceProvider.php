<?php

namespace Application\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Application\Interfaces\Controllers\IAuthController;
use Application\Interfaces\Controllers\IUserController;

class ControllerInterfaceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(IAuthController::class, AuthController::class);

        $this->app->bind(IUserController::class, UserController::class);
    }

    public function boot(): void
    {
        //
    }
}
