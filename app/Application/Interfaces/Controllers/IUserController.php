<?php

namespace Application\Interfaces\Controllers;

use App\Models\User;
use Application\Requests\User\UpdateProfileRequest;
use Illuminate\Http\Resources\Json\JsonResource;

interface IUserController
{
    public function profile(User $user): JsonResource;

    public function update(UpdateProfileRequest $request): array;
}
