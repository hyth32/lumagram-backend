<?php

namespace Application\Interfaces\Controllers;

use Application\Requests\BaseListRequest;
use Application\Requests\Post\StorePostRequest;

interface IPostController
{
    public function index(BaseListRequest $request): array;

    public function store(StorePostRequest $request): array;

    public function show(): array;

    public function destroy(): array;
}
