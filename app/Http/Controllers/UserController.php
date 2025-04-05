<?php

namespace App\Http\Controllers;

use App\Models\User;
use Application\DTOs\User\ProfileDto;
use Application\DTOs\User\UserDto;
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

    public function me(Request $request): JsonResource
    {
        $dto = new UserDto(
            id: $request->user()->id,
            username: $request->user()->username,
        );

        return $this->userService->getProfile($dto);
    }

    public function update(UpdateProfileRequest $request): array
    {
        $userDto = new UserDto(
            id: $request->user()->id,
            username: $request->user()->username,
        );

        $profileDto = new ProfileDto(
            name: $request->input('name'),
            description: $request->input('description'),
            activity_category: $request->input('activityCategory'),
        );

        return $this->userService->updateProfile($userDto, $profileDto);
    }

    public function profile(User $user, Request $request): JsonResource
    {
        $dto = new UserDto(
            id: $user->id,
            username: $user->username,
        );

        return $this->userService->getProfile($dto);
    }
}
