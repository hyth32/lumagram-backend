<?php

namespace App\Http\Controllers;

use Application\DTOs\Auth\RegisterUserDto;
use Application\Interfaces\Services\IAuthService;
use Application\Requests\Auth\RegisterUserRequest;
use Application\Interfaces\Controllers\IAuthController;

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

        $data = $this->authService->registerUser($dto);

        return [
            'success' => true,
            'data' => $data,
        ];
    }

    public function login(): void {}

    public function logout(): void {}

    public function resetPassword(): void {}

    public function refresh(): void {}
}
