<?php

namespace Application\Interfaces\Controllers;

use Application\Requests\Auth\LoginUserRequest;
use Application\Requests\Auth\RegisterUserRequest;

interface IAuthController
{
    public function register(RegisterUserRequest $request): array;
    
    public function login(LoginUserRequest $request): array;

    public function logout(): void;

    public function resetPassword(): void;

    public function refresh(): void;
}
