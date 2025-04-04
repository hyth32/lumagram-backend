<?php

namespace Application\Interfaces\Services;

use Application\DTOs\User\ProfileDto;
use Application\DTOs\User\UserDto;

interface IUserService
{
    public function getProfile(UserDto $dto): array;

    public function updateProfile(UserDto $userDto, ProfileDto $profileDto): array;
}
