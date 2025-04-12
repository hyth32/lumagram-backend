<?php

namespace App\Http\Controllers;

use Application\Interfaces\Controllers\ILikeController;
use Application\Interfaces\Services\ILikeService;

class LikeController extends Controller implements ILikeController
{
    public function __construct(
        private readonly ILikeService $likeService,
    ) {}

    /**
     * @OA\Get(path="/posts/{post}/likes",
     *      tags={"Post"},
     *      summary="Список пользователей, лайкнувших пост",
     *      @OA\Response(response=200, description="Ответ",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(),
     *          )
     *      )
     * )
     */
    public function index(): array
    {
        return $this->likeService->getList();
    }

    /**
     * @OA\Put(path="/posts/{post}/likes",
     *      tags={"Post"},
     *      summary="Поставить/убрать лайк",
     *      @OA\Response(response=200, description="Ответ",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(),
     *          )
     *      )
     * )
     */
    public function toggle(): array
    {
        return $this->likeService->storeToggle();
    }
}
