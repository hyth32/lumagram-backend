<?php

namespace App\Http\Controllers;

use App\Http\Services\PostService;
use App\Models\Post;
use Application\DTOs\Post\PostDto;
use Application\Requests\BaseListRequest;
use Application\Requests\Post\StorePostRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostController extends Controller
{
    public function __construct(
        private readonly PostService $postService,
    ) {}

    /**
     * @OA\Get(path="/feed",
     *      tags={"Post"},
     *      summary="Список постов",
     *      @OA\Response(response=200, description="Ответ",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="posts", type="array", @OA\Items(ref="#/components/schemas/Post"))
     *              ),
     *          )
     *      ),
     * )
     */
    public function index(BaseListRequest $request): array
    {
        return $this->postService->getList($request);
    }

    /**
     * @OA\Get(path="/feed/following",
     *      tags={"Post"},
     *      summary="Список постов подписок",
     *      @OA\Response(response=200, description="Ответ",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="posts", type="array", @OA\Items(ref="#/components/schemas/Post"))
     *              ),
     *          )
     *      ),
     * )
     */
    public function indexFollowing(BaseListRequest $request): array
    {
        return $this->postService->getFollowingList($request, $request->user());
    }

    /**
     * @OA\Post(path="/posts",
     *      tags={"Post"},
     *      summary="Сохранение поста",
     *      @OA\RequestBody(description="Запрос",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="image", type="file", description="Изображение поста"),
     *                  @OA\Property(property="description", type="string", description="Описание поста"),
     *              ),
     *          ),
     *      ),
     *      @OA\Response(response=200, description="Ответ",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/Post"),
     *          )
     *      )
     * )
     */
    public function store(StorePostRequest $request): JsonResource
    {
        $dto = PostDto::fromRequest($request);
        return $this->postService->storePost($request->user(), $dto);
    }

    /**
     * @OA\Get(path="/posts/{post}",
     *      tags={"Post"},
     *      summary="Получение поста",
     *      @OA\Response(response=200, description="Ответ",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/Post"),
     *          )
     *      )
     * )
     */
    public function show(Post $post): JsonResource
    {
        return $this->postService->showPost($post);
    }

    /**
     * @OA\Delete(path="/posts/{post}",
     *      tags={"Post"},
     *      summary="Удаление поста",
     *      @OA\Response(response=200, description="Ответ",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(),
     *          )
     *      )
     * )
     */
    public function destroy(Post $post, Request $request): array
    {
        if ($post->user_id !== $request->user()->id) {
            abort(403, 'Cannot delete post');
        }
        
        return $this->postService->destroyPost($post);
    }
}
