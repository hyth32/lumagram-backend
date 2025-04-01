<?php

use Application\Providers\AppServiceProvider;
use Application\Providers\ServiceInterfaceProvider;
use Application\Providers\ControllerInterfaceProvider;

return [
    AppServiceProvider::class,
    ControllerInterfaceProvider::class,
    ServiceInterfaceProvider::class,
];
