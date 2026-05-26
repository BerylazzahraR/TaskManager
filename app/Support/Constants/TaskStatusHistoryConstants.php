<?php

namespace App\Support\Constants;

class TaskStatusHistoryConstants
{
    public const SOURCE_MANUAL = 'manual';
    public const SOURCE_DRAG_DROP = 'drag_drop';
    public const SOURCE_SYSTEM = 'system';

    public static function allSources(): array
    {
        return [
            self::SOURCE_MANUAL,
            self::SOURCE_DRAG_DROP,
            self::SOURCE_SYSTEM,
        ];
    }
}