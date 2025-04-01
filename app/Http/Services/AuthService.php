<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Application\DTOs\Auth\RegisterUserDto;
use Application\Interfaces\Services\IAuthService;

class AuthService implements IAuthService
{
    public function registerUser(RegisterUserDto $dto): array
    {
        $user = User::create([
            'username' => $dto->username,
            'email' => $dto->email,
            'password' => Hash::make($dto->password),
        ]);

        return [
            'accessToken' => $user->createAccessToken(),
            'refreshToken' => $user->createRefreshToken(),
        ];
    }

    public function loginUser(): void {}

    public function logoutUser(): void {}
    
    public function resetUserPassword(): void {}

    public function refreshAccessToken(): void {}
}
