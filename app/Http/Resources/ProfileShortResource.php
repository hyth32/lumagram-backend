<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileShortResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'username' => $this->user->username,
            'image' => ImageResource::make($this->avatar),
        ];
    }
}
