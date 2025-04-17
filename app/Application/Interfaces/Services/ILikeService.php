<?php

namespace Application\Interfaces\Services;

interface ILikeService
{
    public function getList(): array;

    public function storeToggle(): array;
}
