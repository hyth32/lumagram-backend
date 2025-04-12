<?php

namespace Application\Interfaces\Services;

interface ICommentService
{
    public function getList(): array;

    public function storeComment(): array;

    public function updateComment(): array;

    public function destroyComment(): array;
}
