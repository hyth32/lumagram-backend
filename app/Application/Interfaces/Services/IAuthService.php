<?php

namespace Application\Interfaces\Services;

use Application\DTOs\Auth\LoginUserDto;
use Application\DTOs\Auth\RegisterUserDto;
use Application\Requests\Auth\ResetPasswordRequest;
use Illuminate\Http\Request;

interface IAuthService
{
    public function registerUser(RegisterUserDto $dto): array;

    public function loginUser(LoginUserDto $dto): array;

    public function logoutUser(Request $request): void;

    public function resetUserPassword(ResetPasswordRequest $request): array;

    public function forgotPassword(string $email): array;

    public function refreshAccessToken(): void;
}
