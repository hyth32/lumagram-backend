<?php

namespace App\Http\Services;

use App\Models\Post;
use App\Models\User;
use Application\DTOs\Post\PostDto;
use Illuminate\Support\Facades\DB;
use App\Http\Services\ImageService;
use App\Http\Resources\PostResource;
use Application\Enums\FollowStatus;
use Application\Requests\BaseListRequest;
use Illuminate\Http\Resources\Json\JsonResource;

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

    public function getFollowingList(BaseListRequest $request, User $user)
    {
        $userIds = $user->following()->where('status', FollowStatus::Followed->value())->with('user', fn ($q) => $q->whereHas('posts'))->pluck('user_id');
        $postsQuery = Post::whereIn('user_id', $userIds)->latest();
        $posts = $postsQuery->offset($request->offset)->limit($request->limit)->get();

        return ['posts' => PostResource::collection($posts)];
    }

    public function storePost(User $user, PostDto $dto): array
    {
        DB::transaction(function () use ($user, $dto) {
            $imagePath = "users/$user->username/posts";
            $image = $this->imageService->upload($dto->image, $imagePath);

            $post = $user->posts()->create([
                'image_id' => $image->id,
                'description' => $dto->description,
            ]);

            return PostResource::make($post);
        });

        return [];
    }

    public function showPost(Post $post): JsonResource
    {
        return PostResource::make($post);
    }

    public function destroyPost(Post $post): array
    {
        $post->delete();
        
        return [];
    }
}
