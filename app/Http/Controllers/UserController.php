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
     *              @OA\Schema(
     *                  @OA\Property(property="image", type="file", description="Аватарка пользователя"),
     *                  @OA\Property(property="name", type="string", description="Имя"),
     *                  @OA\Property(property="description", type="string", description="Описание"),
     *                  @OA\Property(property="activityCategory", type="file", description="Категория активности"),
     *                  @OA\Property(property="isPublic", type="boolean", description="Метка открытости профиля"),
     *              ),
     *          ),
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
        $dto = ProfileDto::fromRequest($request);
        return $this->userService->updateProfile($request->user(), $dto);
    }

    /**
     * @OA\Get(path="/open/activities",
     *      tags={"Open"},
     *      summary="Категории активности",
     *      @OA\Response(response=200, description="Ответ",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="activities", type="array", @OA\Items(
     *                      @OA\Property(property="name", type="string", description="Название категории"),
     *                  ))
     *              ),
     *          )
     *      )
     * )
     */
    public function activities(Request $request): array
    {
        return $this->userService->listActivities($request);
    }
}
