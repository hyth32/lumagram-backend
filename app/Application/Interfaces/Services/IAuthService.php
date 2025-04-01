<?php

namespace Application\Interfaces\Services;

use Application\DTOs\Auth\RegisterUserDto;

interface IAuthService
{
    public function registerUser(RegisterUserDto $dto): array;

    public function loginUser(): void;

    public function logoutUser(): void;

    public function resetUserPassword(): void;

    public function refreshAccessToken(): void;
}
