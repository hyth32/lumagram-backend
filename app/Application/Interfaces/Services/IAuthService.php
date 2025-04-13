<?php

namespace Application\Interfaces\Services;

use Illuminate\Http\Request;
use Application\DTOs\Auth\LoginUserDto;
use Application\DTOs\Auth\RegisterUserDto;
use Application\Requests\Auth\ResetPasswordRequest;
use Application\Requests\Auth\ChangePasswordRequest;
use Application\Requests\Auth\ForgotPasswordRequest;

interface IAuthService
{
    public function registerUser(RegisterUserDto $dto): array;

    public function loginUser(LoginUserDto $dto): array;

    public function logoutUser(Request $request): void;

    public function resetUserPassword(ResetPasswordRequest $request): array;

    public function forgotPassword(ForgotPasswordRequest $request): array;

    public function changeUserPassword(ChangePasswordRequest $request): array;

    public function refreshAccessToken(Request $request): array;
}
