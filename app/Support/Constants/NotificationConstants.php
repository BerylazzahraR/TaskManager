<?php

namespace App\Support\Constants;

class NotificationConstants
{
    public const TYPE_TASK_ASSIGNED = 'task_assigned';
    public const TYPE_STATUS_CHANGED = 'status_changed';
    public const TYPE_COMMENT_ADDED = 'comment_added';
    public const TYPE_ATTACHMENT_UPLOADED = 'attachment_uploaded';
    public const TYPE_DEADLINE_REMINDER = 'deadline_reminder';
    public const TYPE_TASK_OVERDUE = 'task_overdue';
    public const TYPE_MEMBER_ADDED = 'member_added';

    public const CHANNEL_IN_APP = 'in_app';
    public const CHANNEL_EMAIL = 'email';

    public const STATUS_PENDING = 'pending';
    public const STATUS_SENT = 'sent';
    public const STATUS_FAILED = 'failed';
    public const STATUS_READ = 'read';

    public static function allTypes(): array
    {
        return [
            self::TYPE_TASK_ASSIGNED, self::TYPE_STATUS_CHANGED, self::TYPE_COMMENT_ADDED,
            self::TYPE_ATTACHMENT_UPLOADED, self::TYPE_DEADLINE_REMINDER, 
            self::TYPE_TASK_OVERDUE, self::TYPE_MEMBER_ADDED,
        ];
    }

    public static function allChannels(): array
    {
        return [
            self::CHANNEL_IN_APP, 
            self::CHANNEL_EMAIL
        ];
    }

    public static function allStatuses(): array
    {
        return [
            self::STATUS_PENDING, 
            self::STATUS_SENT, 
            self::STATUS_FAILED, 
            self::STATUS_READ
        ];
    }
}