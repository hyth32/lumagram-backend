<?php

namespace App\Http\Controllers;

use App\Models\User;
use Application\DTOs\User\ProfileDto;
use Application\Interfaces\Controllers\IUserController;
use Application\Interfaces\Services\IUserService;
use Application\Requests\User\UpdateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserController extends Controller implements IUserController
{
    public function __construct(
        private readonly IUserService $userService
    ) {}

    /**
     * @OA\Get(path="/users/me",
     *      tags={"User"},
     *      summary="Профиль текущего пользователя",
     *      @OA\Response(response=200, description="Ответ",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(),
     *          )
     *      )
     * )
     */
    public function me(Request $request): JsonResource
    {
        return $this->userService->getProfile($request->user());
    }

    /**
     * @OA\Get(path="/users/{user}/profile",
     *      tags={"User"},
     *      summary="Профиль пользователя",
     *      @OA\Response(response=200, description="Ответ",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(),
     *          )
     *      )
     * )
     */
    public function profile(User $user): JsonResource
    {
        return $this->userService->getProfile($user);
    }

    /**
     * @OA\Put(path="/users/me",
     *      tags={"User"},
     *      summary="Редактирование профиля",
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
    public function update(UpdateProfileRequest $request): array
    {
        $profileDto = new ProfileDto(
            name: $request->input('name'),
            description: $request->input('description'),
            activity_category: $request->input('activityCategory'),
            is_public: $request->input('isPublic'),
        );

        return $this->userService->updateProfile($request->user(), $profileDto);
    }
}
