<?php

namespace App\Http\Controllers;

use App\Http\Services\LikeService;
use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function __construct(
        private readonly LikeService $likeService,
    ) {}

    /**
     * @OA\Get(path="/posts/{post}/likes",
     *      tags={"Post"},
     *      summary="Список пользователей, лайкнувших пост",
     *      @OA\Response(response=200, description="Ответ",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="users", type="array", @OA\Items(ref="#/components/schemas/UserShort")),
     *              ),
     *          )
     *      )
     * )
     */
    public function index(Post $post): array
    {
        return $this->likeService->getList($post);
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
    public function toggle(Post $post, Request $request): array
    {
        return $this->likeService->storeToggle($post, $request->user());
    }
}
