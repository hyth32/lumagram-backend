<?php

namespace Application\Enums;

enum FollowingStatus
{
    case NotFollowed;
    case Pending;
    case Followed;

    public function value()
    {
        return match($this) {
            self::NotFollowed => 0,
            self::Pending => 1,
            self::Followed => 2,
        };
    }
}
