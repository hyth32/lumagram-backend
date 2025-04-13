<?php

namespace Application\Interfaces\Services;

use Illuminate\Http\UploadedFile;

interface IImageService
{
    public function upload(UploadedFile $image, string $path);
}
