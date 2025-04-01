<?php

interface IAuthService
{
    public function registerUser(): void;

    public function loginUser(): void;

    public function logoutUser(): void;

    public function resetUserPassword(): void;

    public function refreshAccessToken(): void;
}
