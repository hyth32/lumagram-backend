<?php

namespace Application\DTOs\User;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Spatie\DataTransferObject\DataTransferObject;

class ProfileDto extends DataTransferObject
{
    public ?string $name = null;
    public ?string $description = null;
    public ?string $activity_category = null;
    public ?bool $is_public = true;
    public ?UploadedFile $image;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'activity_category' => $request->input('activityCategory'),
            'is_public' => $request->input('isPublic'),
            'image' => $request->file('image'),
        ]);
    }
}
