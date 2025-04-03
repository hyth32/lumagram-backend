<?php

namespace Application\DTOs\Auth;

class LoginUserDto
{
    public function __construct(
        public string $username,
        public string $password,
        public string $remember_me,
    ) {}
}
