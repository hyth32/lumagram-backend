<?php

namespace Application\Interfaces\Controllers;

interface IPostController
{
    public function store(): array;

    public function show(): array;

    public function destroy(): array;

    public function index(): array;

    public function like(): array;

    public function comment(): array;
}
