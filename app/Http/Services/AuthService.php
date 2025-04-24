<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Application\DTOs\Auth\LoginUserDto;
use Illuminate\Support\Facades\Password;
use Application\DTOs\Auth\RegisterUserDto;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Auth\Access\AuthorizationException;
use Application\Requests\Auth\ResetPasswordRequest;
use Application\Requests\Auth\ChangePasswordRequest;
use Application\Requests\Auth\ForgotPasswordRequest;

class AuthService
{
    public function registerUser(RegisterUserDto $dto): array
    {
        $user = User::create([
            'username' => $dto->username,
            'email' => $dto->email,
            'password' => Hash::make($dto->password),
        ]);

        $user->profile()->create();

        return [
            'username' => $user->username,
            'timestamp' => now(),
            ...$user->createTokens(),
        ];
    }

    public function loginUser(LoginUserDto $dto): array
    {
        $user = User::where('username', $dto->username)->first();

        if (!$user) {
            throw new AuthorizationException('username');
        }
        
        if (!Hash::check($dto->password, $user->password)) {
            throw new AuthorizationException('password');
        }

        return [
            'userId' => $user->id,
            'timestamp' => now(),
            ...$user->createTokens($dto->remember_me),
        ];
    }

    public function logoutUser(Request $request): void
    {
        $request->user()->tokens()->delete();
    }

    public function forgotPassword(ForgotPasswordRequest $request): array
    {
        $user = User::query()
            ->where('email', '=', $request->input('email'))
            ->orWhere('username', '=', $request->input('username'))
            ->first();
        
        $status = Password::sendResetLink(
            ['email' => $user->email],
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
                $user->setPassword($request->input('password'));
                $user->save();
            }
        );

        return ['sent' => $status === Password::PASSWORD_RESET];
    }

    public function changeUserPassword(ChangePasswordRequest $request): array
    {
        $user = $request->user();
        $user->setPassword($request->input('password'));
        $user->save();

        return [];
    }

    public function refreshAccessToken(Request $request): array
    {
        $user = $request->user();
        $user->tokens()->where('name', '=', 'access-token')->delete();

        return ['accessToken' => $user->createAccessToken()];
    }
}
