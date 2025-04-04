<?php

namespace Application\Interfaces\Controllers;

use App\Models\User;
use Application\Requests\User\UpdateProfileRequest;
use Illuminate\Http\Request;

interface IUserController
{
    public function me(Request $request): array;

    public function update(UpdateProfileRequest $request): array;

    public function profile(User $user, Request $request): array;
}
