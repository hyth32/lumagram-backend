<?php

namespace App\Http\Services;

use App\Models\Post;
use App\Models\User;
use App\Http\Resources\LikeResource;

class LikeService
{
    public function getList(Post $post): array
    {
        $likes = $post->likes()->latest();
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
