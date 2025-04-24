<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => ProfileShortResource::make($this->user),
            'text' => $this->text,
            'createdAt' => $this->created_at,
            'isEdited' => $this->is_edited,
        ];
    }
}
