<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

class RouteLoader
{
    public static function load(string $directory, string $prefix, array $middleware)
    {
        foreach (File::allFiles(base_path($directory)) as $routeFile) {
            Route::prefix($prefix)
                ->middleware($middleware)
                ->group(fn () => require $routeFile->getPathname());
        }
    }
}
