<?php

namespace Application\Interfaces\Controllers;

use Application\Requests\Auth\LoginUserRequest;
use Application\Requests\Auth\RegisterUserRequest;
use Illuminate\Http\Request;

interface IAuthController
{
    public function register(RegisterUserRequest $request): array;
    
    public function login(LoginUserRequest $request): array;

    public function logout(Request $request): void;

    public function resetPassword(): void;

    public function refresh(): void;
}
