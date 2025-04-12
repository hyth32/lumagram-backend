<?php

namespace App\Http\Controllers;

use Application\Interfaces\Controllers\IPostController;
use Application\Interfaces\Services\IPostService;

class PostController implements IPostController
{
    public function __construct(
        protected IPostService $postService,
    ) {}

    public function index(): array
    {
        return $this->postService->getList();
    }

    public function store(): array
    {
        return $this->postService->storePost();
    }

    public function show(): array
    {
        return $this->postService->showPost();
    }

    public function destroy(): array
    {
        return $this->postService->destroyPost();
    }

    public function like(): array
    {
        return $this->postService->likePost();
    }

    public function comment(): array
    {
        return $this->postService->addComment();
    }
}
