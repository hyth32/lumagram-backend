<?php

namespace App\Http\Services;

use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use Application\DTOs\Post\PostDto;
use Illuminate\Support\Facades\DB;
use Application\Requests\BaseListRequest;
use Application\Interfaces\Services\IPostService;
use Application\Interfaces\Services\IImageService;

class PostService implements IPostService
{
    public function __construct(
        private readonly IImageService $imageService,
    ) {}

    public function getList(BaseListRequest $request, ?User $user = null): array
    {
        if ($user) {
            $postsQuery = $user->posts()->latest();
        } else {
            $postsQuery = Post::query()->latest();
        }

        $posts = $postsQuery->offset($request->input('offset'))->limit($request->input('limit'))->get();

        return ['posts' => PostResource::collection($posts)];
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
