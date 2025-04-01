<?php

namespace Application\DTOs\Auth;

class RegisterUserDto
{
    public function __construct(
        public string $username,
        public string $email,
        public string $password,
    ) {}
}
