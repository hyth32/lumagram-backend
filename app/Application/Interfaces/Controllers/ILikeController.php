<?php

namespace Application\Interfaces\Controllers;

interface ILikeController
{
    public function index(): array;

    public function toggle(): array;
}
