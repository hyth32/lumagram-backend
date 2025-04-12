<?php

namespace App\Http\Services;

use App\Http\Resources\ProfileResource;
use App\Models\User;
use Application\DTOs\User\ProfileDto;
use Application\Interfaces\Services\IUserService;
use Illuminate\Http\Resources\Json\JsonResource;

class UserService implements IUserService
{
    public function getProfile(User $user): JsonResource
    {
        return ProfileResource::make($user->profile);
    }

    public function updateProfile(User $user, ProfileDto $profileDto): array
    {
        $user->profile()->updateOrCreate([
            'name' => $profileDto->name,
            'description' => $profileDto->description,
            'activity_category' => $profileDto->activity_category,
            'is_public' => $profileDto->is_public,
        ]);

        return [];
    }
}
