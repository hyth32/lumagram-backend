<?php

namespace App\Http\Services;

use App\Http\Resources\FollowerResource;
use App\Http\Resources\ProfileShortResource;
use App\Models\Follower;
use App\Models\User;
use Application\Enums\FollowStatus;
use Application\Requests\BaseListRequest;
use Illuminate\Http\Request;

class FollowService
{
    public function followUser(User $user, Request $request)
    {
        $follower = $request->user();
        $status = $user->profile->is_public
            ? FollowStatus::Followed
            : FollowStatus::Pending;

        $user->followers()->create([
            'follower_id' => $follower->id,
            'status' => $status->value(),
        ]);
    }

    public function unfollowUser(User $user, Request $request)
    {
        $follower = $request->user();
        $user->followers()->where('follower_id', $follower->id)->delete();
    }

    public function followersIndex(User $user, BaseListRequest $request)
    {
        $followersQuery = $user->followers();
        $followers = $followersQuery->offset($request->input('offset'))->limit($request->input('limit'))->get();
        return ['followers' => FollowerResource::collection($followers)];
    }

    public function followingIndex(User $user, BaseListRequest $request)
    {
        $followingQuery = Follower::query()->where('user_id', $user->id);
        $following = $followingQuery->offset($request->input('offset'))->offset($request->input('offset'));

        return ['following' => ProfileShortResource::collection($following)];
    }

    public function followRequestsIndex()
    {
        //
    }

    public function approveFollow()
    {
        //
    }

    public function declineFollow()
    {
        //
    }
}
