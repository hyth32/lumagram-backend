<?php

namespace App\Http\Controllers;

use App\Http\Requests\BaseSearchRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Services\PostService;
use App\Http\Services\UserService;
use Application\DTOs\Image\ImageDto;
use Application\DTOs\User\ProfileDto;
use Application\Requests\BaseListRequest;
use Application\Requests\Image\SaveImageRequest;
use Illuminate\Http\Resources\Json\JsonResource;
use Application\Requests\User\UpdateProfileRequest;
use Application\Requests\User\UpdateUsernameRequest;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
        private readonly PostService $postService,
    ) {}

    /**
     * @OA\Get(path="/users",
     *      tags={"User"},
     *      summary="Список пользователей",
     *      @OA\Parameter(name="offset", @OA\Schema(type="integer"), in="query"),
     *      @OA\Parameter(name="limit", @OA\Schema(type="integer"), in="query"),
     *      @OA\Parameter(name="searchQuery", @OA\Schema(type="string"), in="query"),
     * 
     *      @OA\Response(response=200, description="Ответ",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/UserShort"),
     *          )
     *      )
     * )
     */
    public function list(BaseSearchRequest $request): array
    {
        return $this->userService->listUsers($request);
    }

    /**
     * @OA\Get(path="/users/{user}/profile",
     *      tags={"User"},
     *      summary="Профиль пользователя",
     *      @OA\Response(response=200, description="Ответ",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/User"),
     *          )
     *      )
     * )
     */
    public function profile(User $user): JsonResource
    {
        return $this->userService->getProfile($user);
    }

    /**
     * @OA\Put(path="/users/profile",
     *      tags={"User"},
     *      summary="Редактирование профиля",
     *      @OA\RequestBody(description="Запрос",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="image", type="file", description="Аватарка пользователя"),
     *                  @OA\Property(property="name", type="string", description="Имя"),
     *                  @OA\Property(property="description", type="string", description="Описание"),
     *                  @OA\Property(property="activityCategory", type="string", description="Категория активности"),
     *                  @OA\Property(property="isPublic", type="boolean", description="Метка открытости профиля"),
     *              ),
     *          ),
     *      ),
     *      @OA\Response(response=200, description="Ответ",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/User"),
     *          )
     *      )
     * )
     */
    public function update(UpdateProfileRequest $request): JsonResource
    {
        $dto = ProfileDto::fromRequest($request);
        return $this->userService->updateProfile($request->user(), $dto);
    }

    /**
     * @OA\Put(path="/users/profile/change-username",
     *      tags={"User"},
     *      summary="Редактирование профиля",
     *      @OA\RequestBody(description="Запрос",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="username", type="string", description="Имя пользователя"),
     *              ),
     *          ),
     *      ),
     *      @OA\Response(response=200, description="Ответ",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/User"),
     *          )
     *      )
     * )
     */
    public function updateUsername(UpdateUsernameRequest $request): JsonResource
    {
        $username = $request->validated()['username'];
        return $this->userService->updateUsername($request->user(), $username);
    }

    /**
     * @OA\Put(path="/users/profile/change-image",
     *      tags={"User"},
     *      summary="Редактирование аватарки профиля",
     *      @OA\RequestBody(description="Запрос",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="image", type="file", description="Аватарка пользователя"),
     *              ),
     *          ),
     *      ),
     *      @OA\Response(response=200, description="Ответ",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/User"),
     *          )
     *      )
     * )
     */
    public function updateImage(SaveImageRequest $request)
    {
        $dto = ImageDto::fromRequest($request);
        return $this->userService->updateAvatarImage($request->user(), $dto);
    }

    /**
     * @OA\Delete(path="/users/profile/delete-image",
     *      tags={"User"},
     *      summary="Удаление аватарки",
     *      @OA\Response(response=200, description="Ответ",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/User"),
     *          )
     *      )
     * )
     */
    public function deleteImage(Request $request)
    {
        return $this->userService->deleteAvatar($request->user());
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

    /**
     * @OA\Get(path="/users/{user}/posts",
     *      tags={"User"},
     *      summary="Список постов пользователя",
     *      @OA\Response(response=200, description="Ответ",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="posts", type="array", @OA\Items(ref="#/components/schemas/Post"))
     *              ),
     *          )
     *      )
     * )
     */
    public function getPosts(User $user, BaseListRequest $request): array
    {
        return $this->postService->getList($request, $user);
    }

    /**
     * @OA\Get(path="/users/check",
     *      tags={"User"},
     *      summary="Проверка username",
     *      @OA\Response(response=200, description="Ответ",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="username", type="string", description="Имя пользователя"),
     *              ),
     *          )
     *      )
     * )
     */
    public function check(Request $request): array
    {
        return $this->userService->checkUser($request);
    }
}
