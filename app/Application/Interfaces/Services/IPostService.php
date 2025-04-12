<?php

namespace Application\Interfaces\Services;

interface IPostService
{
    public function getList(): array;

    public function storePost(): array;

    public function showPost(): array;

    public function destroyPost(): array;
}
