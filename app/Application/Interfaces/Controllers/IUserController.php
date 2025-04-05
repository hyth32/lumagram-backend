<?php

namespace Application\Interfaces\Controllers;

use App\Models\User;
use Application\Requests\User\UpdateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

interface IUserController
{
    public function me(Request $request): JsonResource;

    public function update(UpdateProfileRequest $request): array;

    public function profile(User $user, Request $request): JsonResource;
}
