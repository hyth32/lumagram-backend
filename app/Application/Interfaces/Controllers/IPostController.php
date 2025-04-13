<?php

namespace Application\Interfaces\Controllers;

use Application\Requests\Post\StorePostRequest;

interface IPostController
{
    public function index(): array;

    public function store(StorePostRequest $request): array;

    public function show(): array;

    public function destroy(): array;
}
