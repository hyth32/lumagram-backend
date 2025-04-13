<?php

namespace App\Http\Services;

use App\Models\Image;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Application\Interfaces\Services\IImageService;

class ImageService implements IImageService
{
    public function upload(UploadedFile $image, string $path): Image
    {
        $imageInfo = getimagesize($image->getRealPath());
        [$width, $height] = $imageInfo;

        $relativePath = $image->storeAs(
            $path,
            $this->getFileName($image),
            'public',
        );

        return Image::create([
            'mime_type' => $image->getMimeType(),
            'width' => $width,
            'height' => $height,
            'path' => $relativePath,
        ]);
    }

    public function getFileName(UploadedFile $image)
    {
        return Str::uuid() . '.' . $image->extension();
    }
}
