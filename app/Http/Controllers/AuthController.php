<?php

namespace App\Http\Controllers;

use Application\DTOs\Auth\LoginUserDto;
use Application\DTOs\Auth\RegisterUserDto;
use Application\Interfaces\Services\IAuthService;
use Application\Requests\Auth\RefreshTokenRequest;
use Application\Requests\Auth\RegisterUserRequest;
use Application\Interfaces\Controllers\IAuthController;
use Application\Requests\Auth\LoginUserRequest;
use Illuminate\Http\Request;

class AuthController implements IAuthController
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
        );

        return $this->authService->loginUser($dto);
    }

    public function logout(Request $request): void
    {
        return $this->authService->logoutUser($request);
    }

    public function resetPassword(): void {}

    public function refresh(): void {}
}
