<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Application\DTOs\Auth\LoginUserDto;
use Illuminate\Support\Facades\Password;
use Application\DTOs\Auth\RegisterUserDto;
use App\Notifications\ResetPasswordNotification;
use Application\Interfaces\Services\IAuthService;
use Application\Requests\Auth\ResetPasswordRequest;
use Error;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AuthService implements IAuthService
{
    public function registerUser(RegisterUserDto $dto): array
    {
        $user = User::create([
            'username' => $dto->username,
            'email' => $dto->email,
            'password' => Hash::make($dto->password),
        ]);

        return $user->createTokens();
    }

    public function loginUser(LoginUserDto $dto): array
    {
        $user = User::where('username', $dto->username)->first();
        
        if (!Hash::check($dto->password, $user->password)) {
            throw new Error('password');
        }

        return $user->createTokens($dto->remember_me);
    }

    public function logoutUser(Request $request): void
    {
        $request->user()->tokens()->delete();
    }

    public function forgotPassword(string $email): array
    {
        $status = Password::sendResetLink(
            ['email' => $email],
            function (User $user) {
                $token = Password::createToken($user);
                $url = config('app.frontend_url') . '/reset-password?token=' . $token;
                
                $user->notify(new ResetPasswordNotification($url));
            }
        );

        return ['sent' => $status === Password::RESET_LINK_SENT];
    }
    
    public function resetUserPassword(ResetPasswordRequest $request): array
    {
        $status = Password::reset(
            $request->only('email', 'password', 'token'),
            function (User $user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password)
                ])->save();
            }
        );

        return ['sent' => $status === Password::PASSWORD_RESET];
    }

    public function refreshAccessToken(Request $request): array
    {
        $user = $request->user();
        $user->tokens()->where('name', '=', 'access-token')->delete();

        return ['accessToken' => $user->createAccessToken()];
    }
}
