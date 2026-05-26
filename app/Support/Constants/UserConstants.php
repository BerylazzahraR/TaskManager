<?php

namespace App\Support\Constants;

class UserConstants
{
    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';

    public static function defaultStatus(): string
    {
        return self::STATUS_ACTIVE;
    }

    public static function allStatuses(): array
    {
        return [
            self::STATUS_ACTIVE,
            self::STATUS_INACTIVE,
        ];
    }
}