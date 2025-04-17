<?php

namespace Application\Interfaces\Controllers;

interface ICommentController
{
    public function index(): array;

    public function store(): array;

    public function update(): array;

    public function destroy(): array;
}
