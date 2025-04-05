<?php

namespace Application\Interfaces\Services;

use Application\DTOs\User\ProfileDto;
use Application\DTOs\User\UserDto;
use Illuminate\Http\Resources\Json\JsonResource;

interface IUserService
{
    public function getProfile(UserDto $dto): JsonResource;

    public function updateProfile(UserDto $userDto, ProfileDto $profileDto): array;
}
