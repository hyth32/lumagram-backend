<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\ProfileShortResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $user = $request->user();
        $isLiked = (bool) $user->likes()->where('post_id', $this->id)->exists();

        return [
            'id' => $this->id,
            'user' => ProfileShortResource::make($this->user->profile),
            'image' => ImageResource::make($this->image),
            'description' => $this->description,
            'publishedAt' => $this->created_at,
            'likeCount' => $this->likes()->count(),
            'commentCount' => $this->comments()->count(),
            'isLiked' => $isLiked,
        ];
    }
}
