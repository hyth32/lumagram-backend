<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

class ProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $requestUser = $request->user();
        $user = User::where('username', $this->user->username)->first();

        $isFollowing = $requestUser->username == $user->username
            ? (bool) $user->followers()->where('follower_id', $requestUser->id)->exists()
            : null;

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
            'isFollowing' => $isFollowing,
        ];
    }
}
