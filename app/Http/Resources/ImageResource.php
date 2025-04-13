<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'mime' => $this->mime_type,
            'width' => $this->width,
            'height' => $this->height,
            'url' => $this->storage_url,
        ];
    }
}
