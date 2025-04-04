<?php

namespace App\Http\Services;

use App\Http\Resources\ProfileResource;
use App\Models\User;
use Application\DTOs\User\ProfileDto;
use Application\DTOs\User\UserDto;
use Application\Interfaces\Services\IUserService;

class UserService implements IUserService
{
    public function getProfile(UserDto $dto): array
    {
        $user = $this->findUser($dto);

        return [
            'success' => true,
            'data' => [
                'profile' => ProfileResource::make($user->profile),
            ],
        ];
    }

    public function updateProfile(UserDto $userDto, ProfileDto $profileDto): array
    {
        $user = $this->findUser($userDto);

        $user->profile()->updateOrCreate([
            'name' => $profileDto->name,
            'description' => $profileDto->description,
            'activity_category' => $profileDto->activity_category,
        ]);

        return ['success' => true];
    }

    public function findUser(UserDto $dto): ?User
    {
        return User::query()
            ->where('id', '=', $dto->id)
            ->orWhere('username', '=', $dto->username)
            ->first();
    }
}
