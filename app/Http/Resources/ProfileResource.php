<?php

namespace App\Http\Resources;

use App\Models\Follower;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

class ProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $requestUser = $request->user();
        $user = User::where('username', $this->user->username)->first();

        $followingStatus = Follower::getFollowingStatus($user->id, $requestUser->id);

        return [
            'username' => $this->user->username,
            'name' => $this->name,
            'description' => $this->description,
            'activityCategory' => $this->activity_category,
            'isPublic' => $this->is_public,
            'image' => ImageResource::make($this->avatar),
            'postsCount' => $this->user->posts()->count(),
            'followersCount' => $this->user->followers_count,
            'followingCount' => $this->user->following_count,
            'followingStatus' => $followingStatus,
        ];
    }
}
