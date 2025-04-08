<?php

namespace App\Http\Services;

use App\Http\Resources\ProfileResource;
use App\Models\User;
use Application\DTOs\User\ProfileDto;
use Application\DTOs\User\UserDto;
use Application\Interfaces\Services\IUserService;
use Illuminate\Http\Resources\Json\JsonResource;

class UserService implements IUserService
{
    public function getProfile(UserDto $dto): JsonResource
    {
        $user = $this->findUser($dto);

        return ProfileResource::make($user->profile);
    }

    public function updateProfile(UserDto $userDto, ProfileDto $profileDto): array
    {
        $user = $this->findUser($userDto);

        $user->profile()->updateOrCreate([
            'name' => $profileDto->name,
            'description' => $profileDto->description,
            'activity_category' => $profileDto->activity_category,
            'is_public' => $profileDto->is_public,
        ]);

        return [];
    }

    public function findUser(UserDto $dto): ?User
    {
        return User::query()
            ->where('id', '=', $dto->id)
            ->orWhere('username', '=', $dto->username)
            ->first();
    }
}
