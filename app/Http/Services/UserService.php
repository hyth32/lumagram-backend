<?php

namespace App\Http\Services;

use App\Http\Resources\ActivityResource;
use App\Http\Resources\ProfileResource;
use App\Models\Activity;
use App\Models\User;
use Application\DTOs\User\ProfileDto;
use Application\Interfaces\Services\IImageService;
use Application\Interfaces\Services\IUserService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserService implements IUserService
{
    public function __construct(
        private readonly IImageService $imageService,
    ) {}

    public function getProfile(User $user): JsonResource
    {
        return ProfileResource::make($user->profile);
    }

    public function updateProfile(User $user, ProfileDto $dto): array
    {
        $imagePath = "users/$user->username/profile";
        $image = $this->imageService->upload($dto->image, $imagePath);

        $user->profile()->updateOrCreate([
            'name' => $dto->name,
            'description' => $dto->description,
            'activity_category' => $dto->activity_category,
            'is_public' => $dto->is_public,
            'image_id' => $image->id,
        ]);

        return [];
    }

    public function listActivities(Request $request): array
    {
        $activities = Activity::query()->get();
        return ['activities' => ActivityResource::collection($activities)];
    }
}
