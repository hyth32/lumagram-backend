<?php

namespace Application\Interfaces\Controllers;

use App\Models\User;
use Application\Requests\BaseListRequest;
use Illuminate\Http\Resources\Json\JsonResource;
use Application\Requests\User\UpdateProfileRequest;

interface IUserController
{
    public function profile(User $user): JsonResource;

    public function update(UpdateProfileRequest $request): array;

    public function getPosts(User $user, BaseListRequest $request): array;
}
