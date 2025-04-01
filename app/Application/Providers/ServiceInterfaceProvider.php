<?php

namespace Application\Providers;

use IAuthService;
use App\Http\Services\AuthService;
use Illuminate\Support\ServiceProvider;

class ServiceInterfaceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(IAuthService::class, AuthService::class);
    }

    public function boot(): void
    {
        //
    }
}
