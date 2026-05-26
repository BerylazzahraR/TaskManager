<?php

namespace App\Support\Constants;

class TeamMemberConstants
{
    public const ROLE_OWNER = 'owner';
    public const ROLE_ADMIN = 'admin';
    public const ROLE_MEMBER = 'member';

    public const STATUS_ACTIVE = 'active';
    public const STATUS_REMOVED = 'removed';

    public static function allRoles(): array
    {
        return [
            self::ROLE_OWNER, 
            self::ROLE_ADMIN, 
            self::ROLE_MEMBER
        ];
    }

    public static function allStatuses(): array
    {
        return [
            self::STATUS_ACTIVE, 
            self::STATUS_REMOVED
        ];
    }
}