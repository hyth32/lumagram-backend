<?php

namespace Application\Interfaces\Controllers;

use Illuminate\Http\Request;
use Application\Requests\Auth\LoginUserRequest;
use Application\Requests\Auth\RegisterUserRequest;
use Application\Requests\Auth\ResetPasswordRequest;
use Application\Requests\Auth\ChangePasswordRequest;
use Application\Requests\Auth\ForgotPasswordRequest;

interface IAuthController
{
    public function register(RegisterUserRequest $request): array;
    
    public function login(LoginUserRequest $request): array;

    public function logout(Request $request): void;

    public function forgotPassword(ForgotPasswordRequest $request): array;
    
    public function resetPassword(ResetPasswordRequest $request): array;

    public function changePassword(ChangePasswordRequest $request): array;

    public function refresh(Request $request): array;
}
