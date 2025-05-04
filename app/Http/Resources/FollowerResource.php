<?php

namespace App\Http\Resources;

use App\Models\Follower;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FollowerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $requestUser = $request->user();
        $follower = User::where('id', $this->follower->id)->first();
        
        $followingStatus = Follower::getFollowingStatus($follower->id, $requestUser->id);

        return [
            'username' => $follower->username,
            'image' => ImageResource::make($follower->profile->avatar),
            'followingStatus' => $followingStatus,
        ];
    }
}
