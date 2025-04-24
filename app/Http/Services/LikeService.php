<?php

namespace App\Http\Services;

use App\Models\Post;
use App\Models\User;
use App\Http\Resources\LikeResource;
use Application\Requests\BaseListRequest;

class LikeService
{
    public function getList(Post $post, BaseListRequest $request): array
    {
        $likesQuery = $post->likes()->latest();
        $likes = $likesQuery->offset($request->input('offset'))->limit($request->input('limit'))->get();

        return ['likes' => LikeResource::collection($likes)];
    }

    public function storeToggle(Post $post, User $user): array
    {
        $userLikes = $user->likes(); 
        $postLike = $userLikes->where('post_id', $post->id)->first();

        if (!$postLike) {
            $userLikes->create(['post_id' => $post->id]);
        } else {
            $postLike->delete();
        }

        return [];
    }
}
