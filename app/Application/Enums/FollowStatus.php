<?php

namespace Application\Enums;

enum FollowStatus
{
    case Pending;
    case Followed;

    public function value()
    {
        return match($this) {
            self::Pending => 'pending',
            self::Followed => 'followed',
        };
    }
}
