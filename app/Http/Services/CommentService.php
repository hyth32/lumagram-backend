<?php

namespace App\Http\Services;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use Application\Requests\BaseListRequest;
use Application\Requests\Comment\StoreCommentRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentService
{
    public function getList(Post $post, BaseListRequest $request): array
    {
        $commentQuery = $post->comments();
        $comments = $commentQuery->offset($request->input('offset'))->limit($request->input('limit'))->get();

        return ['comments' => CommentResource::collection($comments)];
    }

    public function storeComment(Post $post, StoreCommentRequest $request): JsonResource
    {
        $text = $request->validated()['text'];
        $user = $request->user();

        $comment = $user->comments()->create([
            'post_id' => $post->id,
            'text' => $text,
        ]);

        return CommentResource::make($comment);
    }

    public function updateComment(Comment $comment, StoreCommentRequest $request): JsonResource
    {
        $text = $request->validated()['text'];

        $comment->update(['text' => $text]);

        return CommentResource::make($comment);
    }

    public function destroyComment(Comment $comment): array
    {
        $comment->delete();

        return [];
    }
}
