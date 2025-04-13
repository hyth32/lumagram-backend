<?php

namespace Application\Interfaces\Services;

use App\Models\User;
use Application\DTOs\Post\PostDto;

interface IPostService
{
    public function getList(): array;

    public function storePost(User $user, PostDto $dto): array;

    public function showPost(): array;

    public function destroyPost(): array;
}
