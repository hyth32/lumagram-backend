<?php

namespace Application\DTOs\User;

class ProfileDto
{
    public function __construct(
        public ?string $name = null,
        public ?string $description = null,
        public ?string $activity_category = null,
    ) {}
}
