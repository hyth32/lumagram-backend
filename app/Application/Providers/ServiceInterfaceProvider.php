<?php

namespace Application\Providers;

use App\Http\Services\AuthService;
use Illuminate\Support\ServiceProvider;
use Application\Interfaces\Services\IAuthService;

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
