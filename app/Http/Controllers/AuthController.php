<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\ChangePasswordRequest;
use Application\DTOs\Auth\LoginUserDto;
use Application\DTOs\Auth\RegisterUserDto;
use Application\Interfaces\Services\IAuthService;
use Application\Requests\Auth\RegisterUserRequest;
use Application\Interfaces\Controllers\IAuthController;
use Application\Requests\Auth\LoginUserRequest;
use Application\Requests\Auth\ForgotPasswordRequest;
use Application\Requests\Auth\ResetPasswordRequest;
use Illuminate\Http\Request;

class AuthController extends Controller implements IAuthController
{
    public function __construct(
        private readonly IAuthService $authService
    ) {}

    /**
     * @OA\Post(path="/auth/register",
     *      tags={"Auth"},
     *      summary="Регистрация",
     *      @OA\RequestBody(description="Запрос",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(),
     *          )
     *      ),
     *      @OA\Response(response=200, description="Ответ",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(),
     *          )
     *      )
     * )
     */
    public function register(RegisterUserRequest $request): array
    {
        $dto = new RegisterUserDto(
            username: $request->input('username'),
            email: $request->input('email'),
            password: $request->input('password')
        );

        return $this->authService->registerUser($dto);
    }

    /**
     * @OA\Post(path="/auth/login",
     *      tags={"Auth"},
     *      summary="Вход",
     *      @OA\RequestBody(description="Запрос",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(),
     *          )
     *      ),
     *      @OA\Response(response=200, description="Ответ",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(),
     *          )
     *      )
     * )
     */
    public function login(LoginUserRequest $request): array
    {
        $dto = new LoginUserDto(
            username: $request->input('username'),
            password: $request->input('password'),
            remember_me: $request->input('rememberMe'),
        );

        return $this->authService->loginUser($dto);
    }

    /**
     * @OA\Post(path="/auth/logout",
     *      tags={"Auth"},
     *      summary="Выход",
     *      @OA\RequestBody(description="Запрос",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(),
     *          )
     *      ),
     *      @OA\Response(response=200, description="Ответ",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(),
     *          )
     *      )
     * )
     */
    public function logout(Request $request): void
    {
        $this->authService->logoutUser($request);
    }

    /**
     * @OA\Post(path="/auth/forgot-password",
     *      tags={"Auth"},
     *      summary="Запрос на сброс пароля",
     *      @OA\RequestBody(description="Запрос",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(),
     *          )
     *      ),
     *      @OA\Response(response=200, description="Ответ",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(),
     *          )
     *      )
     * )
     */
    public function forgotPassword(ForgotPasswordRequest $request): array
    {
        return $this->authService->forgotPassword($request);
    }

    /**
     * @OA\Post(path="/auth/reset-password",
     *      tags={"Auth"},
     *      summary="Обновление пароля после сброса",
     *      @OA\RequestBody(description="Запрос",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(),
     *          )
     *      ),
     *      @OA\Response(response=200, description="Ответ",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(),
     *          )
     *      )
     * )
     */
    public function resetPassword(ResetPasswordRequest $request): array
    {
        return $this->authService->resetUserPassword($request);
    }

    /**
     * @OA\Post(path="/auth/reset-password",
     *      tags={"Auth"},
     *      summary="Смена пароля",
     *      @OA\RequestBody(description="Запрос",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(),
     *          )
     *      ),
     *      @OA\Response(response=200, description="Ответ",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(),
     *          )
     *      )
     * )
     */
    public function changePassword(ChangePasswordRequest $request): array
    {
        return $this->authService->changeUserPassword($request);
    }

    /**
     * @OA\Post(path="/auth/refresh",
     *      tags={"Auth"},
     *      summary="Обновление access токена",
     *      @OA\RequestBody(description="Запрос",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(),
     *          )
     *      ),
     *      @OA\Response(response=200, description="Ответ",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(),
     *          )
     *      )
     * )
     */
    public function refresh(Request $request): array
    {
        return $this->authService->refreshAccessToken($request);
    }
}
