<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Services\CommentService;
use App\Models\Comment;
use Application\Requests\BaseListRequest;
use Application\Requests\Comment\StoreCommentRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentController extends Controller
{
    public function __construct(
        private readonly CommentService $commentService,
    ) {}

    /**
     * @OA\Get(path="/posts/{post}/comments",
     *      tags={"Post"},
     *      summary="Список комментариев",
     *      @OA\Response(response=200, description="Ответ",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="comments", type="array", @OA\Items(ref="#/components/schemas/Comment")),
     *              ),
     *          )
     *      )
     * )
     */
    public function index(Post $post, BaseListRequest $request): array
    {
        return $this->commentService->getList($post, $request);
    }

    /**
     * @OA\Post(path="/posts/{post}/comments",
     *      tags={"Post"},
     *      summary="Добавление комментария",
     *      @OA\RequestBody(description="Запрос",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="text", type="string", description="Текст комментария"),
     *              ),
     *          )
     *      ),
     *      @OA\Response(response=200, description="Ответ",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/Comment"),
     *          )
     *      )
     * )
     */
    public function store(Post $post, StoreCommentRequest $request): JsonResource
    {
        return $this->commentService->storeComment($post, $request);
    }

    
    /**
     * @OA\Put(path="/comments/{comment}",
     *      tags={"Post"},
     *      summary="Редактирование комментария",
     *      @OA\RequestBody(description="Запрос",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="text", type="string", description="Текст комментария"),
     *              ),
     *          )
     *      ),
     *      @OA\Response(response=200, description="Ответ",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/Comment"),
     *          )
     *      )
     * )
     */
    public function update(Comment $comment, StoreCommentRequest $request): JsonResource
    {
        if ($comment->user_id !== $request->user()->id) {
            abort(403, 'Cannot update comment');
        }

        return $this->commentService->updateComment($comment, $request);
    }

    /**
     * @OA\Delete(path="/comments/{comment}",
     *      tags={"Post"},
     *      summary="Удаление комментария",
     *      @OA\Response(response=200, description="Ответ",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(),
     *          )
     *      )
     * )
     */
    public function destroy(Comment $comment, Request $request): array
    {
        if ($comment->user_id !== $request->user()->id) {
            abort(403, 'Cannot delete comment');
        }

        return $this->commentService->destroyComment($comment);
    }
}
