<?php

namespace Application\Enums;

enum FollowStatus
{
    use EnumTrait;

    case Pending;
    case Followed;

    public function value()
    {
        return match($this) {
            self::Pending => 0,
            self::Followed => 1,
        };
    }

    public function label()
    {
        return match($this) {
            self::Pending => 'pending',
            self::Followed => 'followed',
        };
    }
}
