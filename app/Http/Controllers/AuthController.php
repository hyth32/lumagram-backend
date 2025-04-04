<?php

namespace App\Http\Controllers;

use Application\DTOs\Auth\LoginUserDto;
use Application\DTOs\Auth\RegisterUserDto;
use Application\Interfaces\Services\IAuthService;
use Application\Requests\Auth\RegisterUserRequest;
use Application\Interfaces\Controllers\IAuthController;
use Application\Requests\Auth\LoginUserRequest;
use Application\Requests\Auth\ForgotPasswordRequest;
use Application\Requests\Auth\ResetPasswordRequest;
use Illuminate\Http\Request;

class AuthController extends Controller implements IAuthController
{
    public function __construct(
        private readonly IAuthService $authService
    ) {}

    public function register(RegisterUserRequest $request): array
    {
        $dto = new RegisterUserDto(
            username: $request->input('username'),
            email: $request->input('email'),
            password: $request->input('password')
        );

        return $this->authService->registerUser($dto);
    }

    public function login(LoginUserRequest $request): array
    {
        $dto = new LoginUserDto(
            username: $request->input('username'),
            password: $request->input('password'),
            remember_me: $request->input('rememberMe'),
        );

        return $this->authService->loginUser($dto);
    }

    public function logout(Request $request): void
    {
        $this->authService->logoutUser($request);
    }

    public function resetPassword(ResetPasswordRequest $request): array
    {
        return $this->authService->resetUserPassword($request);
    }

    public function forgotPassword(ForgotPasswordRequest $request): array
    {
        return $this->authService->forgotPassword($request->input('email'));
    }

    public function refresh(Request $request): array
    {
        return $this->authService->refreshAccessToken($request);
    }
}
