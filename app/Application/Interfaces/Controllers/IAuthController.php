<?php

namespace Application\Interfaces\Controllers;

interface IAuthController
{
    public function register(): void;
    
    public function login(): void;

    public function logout(): void;

    public function resetPassword(): void;

    public function refresh(): void;
}
