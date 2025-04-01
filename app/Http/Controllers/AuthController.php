<?php

namespace App\Http\Controllers;

use Application\Interfaces\Controllers\IAuthController;

class AuthController implements IAuthController
{
    public function register(): void {}

    public function login(): void {}

    public function logout(): void {}

    public function resetPassword(): void {}

    public function refresh(): void {}
}
