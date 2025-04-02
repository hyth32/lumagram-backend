<?php

namespace App\Http\Services;

use App\Models\User;
use Application\DTOs\Auth\LoginUserDto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
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

    public function forgotPassword(string $email): array
    {
        $status = Password::sendResetLink(['email' => $email]);

        return ['success' => $status === Password::RESET_LINK_SENT];
    }
    
    public function resetUserPassword(Request $request): array
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password)
                ])->save();
            }
        );

        return ['success' => $status === Password::PASSWORD_RESET];
    }

    public function refreshAccessToken(): void {}
}
