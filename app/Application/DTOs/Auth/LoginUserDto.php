<?php

namespace Application\DTOs\Auth;

class LoginUserDto
{
    public function __construct(
        public string $username,
        public string $password,
        public bool $remember_me,
    ) {}
}
