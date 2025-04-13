<?php

namespace App\Http\Services;

use App\Models\User;
use Application\DTOs\Post\PostDto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Application\Interfaces\Services\IPostService;
use Application\Interfaces\Services\IImageService;

class PostService implements IPostService
{
    public function __construct(
        private readonly IImageService $imageService,
    ) {}

    public function getList(): array
    {
        return [];
    }

    public function storePost(User $user, PostDto $dto): array
    {
        DB::transaction(function () use ($user, $dto) {
            $imagePath = "users/$user->username/posts";
            $image = $this->imageService->upload($dto->image, $imagePath);

            $user->posts()->create([
                'image_id' => $image->id,
                'description' => $dto->description,
            ]);
        });

        return [];
    }

    public function showPost(): array
    {
        return [];
    }

    public function destroyPost(): array
    {
        return [];
    }
}
