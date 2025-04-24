<?php

namespace App\Http\Services;

use App\Models\Post;
use App\Models\User;
use Application\DTOs\Post\PostDto;
use Illuminate\Support\Facades\DB;
use App\Http\Services\ImageService;
use App\Http\Resources\PostResource;
use Application\Requests\BaseListRequest;

class PostService
{
    public function __construct(
        private readonly ImageService $imageService,
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
