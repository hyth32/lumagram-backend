<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FollowerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $isFollowing = $this->user()->followers()
            ->where('follower_id', $request->user()->id)
            ->exists();

        return [
            'username' => $this->user->username,
            'image' => ImageResource::make($this->avatar),
            'isFollowing' => (bool) $isFollowing,
        ];
    }
}
