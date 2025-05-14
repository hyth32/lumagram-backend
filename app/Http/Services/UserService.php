<?php

namespace App\Http\Services;

use App\Http\Requests\BaseSearchRequest;
use App\Models\User;
use App\Models\Activity;
use App\Http\Services\ImageService;
use Application\DTOs\User\ProfileDto;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\ActivityResource;
use App\Http\Resources\UserShortResource;
use App\Models\Follower;
use Application\DTOs\Image\ImageDto;
use Application\Enums\FollowStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserService
{
    public function __construct(
        private readonly ImageService $imageService,
    ) {}

    public function listUsers(BaseSearchRequest $request): array
    {
        $usersQuery = User::query()
            ->when(!empty($request->searchQuery), fn ($query) =>
                $query->where('username', 'ilike', '%' . $request->searchQuery . '%'),
            );

        $users = $usersQuery->offset($request->offset)->limit($request->limit)->get();

        return ['users' => UserShortResource::collection($users)];
    }

    public function getProfile(User $user): JsonResource
    {
        return ProfileResource::make($user->profile);
    }

    public function updateProfile(User $user, ProfileDto $dto): JsonResource
    {
        $profile = $user->profile();
        $isPublic = $user->profile->is_public;
        $profileData = [
            'name' => $dto->name,
            'description' => $dto->description,
            'activity_category' => $dto->activity_category,
            'is_public' => $dto->is_public,
        ];

        if (!$profile->exists()) {
            $profile->create($profileData);
        } else {
            $profile->update($profileData);
            if (!$isPublic && $dto->is_public) {
                Follower::where('user_id', $user->id)
                    ->where('status', FollowStatus::Pending->value)
                    ->update(['status' => FollowStatus::Followed->value()]);
            }
        }

        return ProfileResource::make($user->profile);
    }

    public function updateUsername(User $user, string $username): JsonResource
    {
        $user->update(['username' => $username]);

        return ProfileResource::make($user->profile);
    }

    public function updateAvatarImage(User $user, ImageDto $dto): JsonResource
    {
        $imagePath = "users/$user->username/profile";
        $image = $this->imageService->upload($dto->image, $imagePath);
        
        $user->profile()->update(['image_id' => $image->id]);

        return ProfileResource::make($user->profile);
    }

    public function deleteAvatar(User $user)
    {
        $user->profile->avatar()->delete();
    }

    public function listActivities(): array
    {
        $activities = Activity::query()->get();
        return ['activities' => ActivityResource::collection($activities)];
    }

    public function checkUser(Request $request): array
    {
        return ['username' => $request->user()->username];
    }
}
