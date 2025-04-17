<?php

namespace Application\DTOs\Post;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Spatie\DataTransferObject\DataTransferObject;

class PostDto extends DataTransferObject
{
    public UploadedFile $image;
    public ?string $description;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'image' => $request->file('image'),
            'description' => $request->input('description'),
        ]);
    }
}
