<?php

namespace Application\Interfaces\Controllers;

use Application\Requests\Auth\LoginUserRequest;
use Application\Requests\Auth\RegisterUserRequest;
use Application\Requests\Auth\ForgotPasswordRequest;
use Application\Requests\Auth\ResetPasswordRequest;
use Illuminate\Http\Request;

interface IAuthController
{
    public function register(RegisterUserRequest $request): array;
    
    public function login(LoginUserRequest $request): array;

    public function logout(Request $request): void;

    public function resetPassword(ResetPasswordRequest $request): array;

    public function forgotPassword(ForgotPasswordRequest $request): array;

    public function refresh(Request $request): array;
}
