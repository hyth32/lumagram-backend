<?php

namespace App\Http\Services;

use App\Models\User;
use Application\DTOs\Auth\LoginUserDto;
use Illuminate\Http\Request;
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
            'success' => true,
            'data' => [
                'accessToken' => $user->createAccessToken(),
                'refreshToken' => $user->createRefreshToken(),
            ],
        ];
    }

    public function loginUser(LoginUserDto $dto): array
    {
        $user = User::where('username', $dto->username)->first();
        
        if (!Hash::check($dto->password, $user->password)) {
            return [
                'success' => false,
                'error' => 'Invalid credentials',
            ];
        }

        if ($user->hasPasswordChangeMark()) {
            return [
                'success' => true,
                'data' => [
                    'password_reset' => true,
                ],
            ];
        }

        $user->tokens()->delete();

        return [
            'success' => true,
            'data' => [
                'accessToken' => $user->createAccessToken(),
                'refreshToken' => $user->createRefreshToken(),
            ],
        ];
    }

    public function logoutUser(Request $request): void
    {
        $request->user()->tokens()->delete();
    }
    
    public function resetUserPassword(Request $request): array
    {
        $request->user()->markPasswordChange();

        return ['success' => true];
    }

    public function refreshAccessToken(): void {}
}
