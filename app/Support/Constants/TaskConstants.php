<?php

namespace App\Support\Constants;

class TaskConstants
{
    public const STATUS_TODO = 'todo';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_DONE = 'done';

    public const PRIORITY_LOW = 'low';
    public const PRIORITY_MEDIUM = 'medium';
    public const PRIORITY_HIGH = 'high';

    public static function defaultStatus(): string
    {
        return self::STATUS_TODO;
    }

    public static function defaultPriority(): string
    {
        return self::PRIORITY_MEDIUM;
    }

    public static function allStatuses(): array
    {
        return [
            self::STATUS_TODO, 
            self::STATUS_IN_PROGRESS, 
            self::STATUS_DONE
        ];
    }

    public static function allPriorities(): array
    {
        return [
            self::PRIORITY_LOW, 
            self::PRIORITY_MEDIUM, 
            self::PRIORITY_HIGH
        ];
    }
}