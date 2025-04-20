<?php

namespace Application\Interfaces\Services;

use App\Models\User;
use Application\DTOs\User\ProfileDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

interface IUserService
{
    public function getProfile(User $user): JsonResource;

    public function updateProfile(User $user, ProfileDto $profileDto): array;

    public function listActivities(Request $request): array;
}
