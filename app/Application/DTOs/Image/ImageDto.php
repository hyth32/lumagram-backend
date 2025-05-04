<?php

namespace Application\DTOs\Image;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Spatie\DataTransferObject\DataTransferObject;

class ImageDto extends DataTransferObject
{
    public ?UploadedFile $image;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'image' => $request->file('image'),
        ]);
    }
}
