<?php

namespace Application\DTOs\User;

class UserDto
{
    public function __construct(
        public string $id,
        public string $username,
        public ?string $email = null,
    ) {}
}
