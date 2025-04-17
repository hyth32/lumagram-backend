<?php

namespace App\Http\Controllers;

use Application\Interfaces\Controllers\ICommentController;
use Application\Interfaces\Services\ICommentService;

class CommentController extends Controller implements ICommentController
{
    public function __construct(
        private readonly ICommentService $commentService,
    ) {}

    /**
     * @OA\Get(path="/posts/{post}/comments",
     *      tags={"Post"},
     *      summary="Список комментариев",
     *      @OA\Response(response=200, description="Ответ",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(),
     *          )
     *      )
     * )
     */
    public function index(): array
    {
        return $this->commentService->getList();
    }

    /**
     * @OA\Post(path="/posts/{post}/comments",
     *      tags={"Post"},
     *      summary="Добавление комментария",
     *      @OA\RequestBody(description="Запрос",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(),
     *          )
     *      ),
     *      @OA\Response(response=200, description="Ответ",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(),
     *          )
     *      )
     * )
     */
    public function store(): array
    {
        return $this->commentService->storeComment();
    }

    
    /**
     * @OA\Put(path="/posts/{post}/comments/{comment}",
     *      tags={"Post"},
     *      summary="Редактирование комментария",
     *      @OA\Response(response=200, description="Ответ",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(),
     *          )
     *      )
     * )
     */
    public function update(): array
    {
        return $this->commentService->updateComment();
    }

    /**
     * @OA\Delete(path="/posts/{post}/comments/{comment}",
     *      tags={"Post"},
     *      summary="Удаление комментария",
     *      @OA\Response(response=200, description="Ответ",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(),
     *          )
     *      )
     * )
     */
    public function destroy(): array
    {
        return $this->commentService->destroyComment();
    }
}
