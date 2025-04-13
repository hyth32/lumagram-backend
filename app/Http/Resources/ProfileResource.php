<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->user->id,
            'username' => $this->user->username,
            'name' => $this->name,
            'description' => $this->description,
            'activityCategory' => $this->activity_category,
            'isPublic' => $this->is_public,
            'image' => ImageResource::make($this->avatar),
        ];
    }
}
