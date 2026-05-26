<?php

namespace App\Support\Constants;

class TeamConstants
{
    public const STATUS_ACTIVE = 'active';
    public const STATUS_ARCHIVED = 'archived';

    public const VISIBILITY_PRIVATE = 'private';
    public const VISIBILITY_INTERNAL = 'internal';

    public static function allStatuses(): array
    {
        return [
            self::STATUS_ACTIVE, 
            self::STATUS_ARCHIVED
        ];
    }

    public static function allVisibility(): array
    {
        return [
            self::VISIBILITY_PRIVATE, 
            self::VISIBILITY_INTERNAL
        ];
    }
}