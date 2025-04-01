<?php

namespace Application\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\AuthController;
use Application\Interfaces\Controllers\IAuthController;

class ControllerInterfaceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(IAuthController::class, AuthController::class);
    }

    public function boot(): void
    {
        //
    }
}
