<?php

namespace App\Http\Services;

use App\Models\Image;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Application\Interfaces\Services\IImageService;
use Illuminate\Support\Facades\Storage;

class ImageService implements IImageService
{
    public function upload(UploadedFile $image, string $path): ?Image
    {
        if (empty($image)) {
            return null;
        }

        Storage::disk('public')->makeDirectory($path);

        $imageInfo = getimagesize($image->getRealPath());
        [$width, $height] = $imageInfo;
        $fileName = $this->getFileName($image);

        $image->storeAs(
            $path,
            $fileName,
            'public',
        );

        return Image::create([
            'mime_type' => $image->getMimeType(),
            'width' => $width,
            'height' => $height,
            'path' => "$path/$fileName",
        ]);
    }

    public function getFileName(UploadedFile $image)
    {
        return Str::uuid() . '.' . $image->getClientOriginalExtension();
    }
}
