<?php

namespace App\Http\Controllers;

use App\Http\Services\FollowService;

class FollowController extends Controller
{
    public function __construct(
        private readonly FollowService $followService,
    ) {}

    /**
     * @OA\Post(path="/users/{user}/follow",
     *      tags={"Follow"},
     *      summary="Подписаться",
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
    public function follow()
    {
        return $this->followService->followUser();
    }

    /**
     * @OA\Post(path="/users/{user}/unfollow",
     *      tags={"Follow"},
     *      summary="Отписаться",
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
    public function unfollow()
    {
        return $this->followService->unfollowUser();
    }

    /**
     * @OA\Get(path="/users/{user}/followers",
     *      tags={"Follow"},
     *      summary="Список подписчиков",
     *      @OA\Response(response=200, description="Ответ",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/Follower"),
     *          )
     *      )
     * )
     */
    public function followers()
    {
        return $this->followService->followersIndex();
    }

    /**
     * @OA\Get(path="/users/{user}/following",
     *      tags={"Follow"},
     *      summary="Список подписок",
     *      @OA\Response(response=200, description="Ответ",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/UserShort"),
     *          )
     *      )
     * )
     */
    public function following()
    {
        return $this->followService->followingIndex();
    }

    /**
     * @OA\Get(path="/users/follow-requests",
     *      tags={"Follow"},
     *      summary="Список запросов на подписку",
     *      @OA\Response(response=200, description="Ответ",
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/UserShort"),
     *          )
     *      )
     * )
     */
    public function followRequests()
    {
        return $this->followService->followRequestsIndex();
    }

    /**
     * @OA\Post(path="/users/follow-requests/{user}",
     *      tags={"Follow"},
     *      summary="Подтвердить запрос на подписку",
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
    public function approveFollowRequest()
    {
        return $this->followService->approveFollow();
    }

    /**
     * @OA\Delete(path="/users/follow-requests/{user}",
     *      tags={"Follow"},
     *      summary="Отклонить запрос на подписку",
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
    public function declineFollowRequest()
    {
        return $this->followService->declineFollow();
    }
}
