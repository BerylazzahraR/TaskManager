<?php

namespace App\Support\Constants;

class WorkspaceActivityConstants
{
    public const ACTION_TEAM_CREATED = 'team_created';
    public const ACTION_TEAM_UPDATED = 'team_updated';
    public const ACTION_TEAM_DELETED = 'team_deleted';
    
    public const ACTION_MEMBER_ADDED = 'member_added';
    public const ACTION_MEMBER_REMOVED = 'member_removed';
    public const ACTION_ROLE_CHANGED = 'role_changed';
    
    public const ACTION_TASK_CREATED = 'task_created';
    public const ACTION_TASK_UPDATED = 'task_updated';
    public const ACTION_TASK_DELETED = 'task_deleted';
    public const ACTION_TASK_ASSIGNED = 'task_assigned';
    
    public const ACTION_STATUS_CHANGED = 'status_changed';
    public const ACTION_DEADLINE_CHANGED = 'deadline_changed';
    
    public const ACTION_COMMENT_ADDED = 'comment_added';
    public const ACTION_COMMENT_DELETED = 'comment_deleted';
    
    public const ACTION_ATTACHMENT_UPLOADED = 'attachment_uploaded';
    public const ACTION_ATTACHMENT_DELETED = 'attachment_deleted';

    public static function allActions(): array
    {
        return [
            self::ACTION_TEAM_CREATED, self::ACTION_TEAM_UPDATED, self::ACTION_TEAM_DELETED,
            self::ACTION_MEMBER_ADDED, self::ACTION_MEMBER_REMOVED, self::ACTION_ROLE_CHANGED,
            self::ACTION_TASK_CREATED, self::ACTION_TASK_UPDATED, self::ACTION_TASK_DELETED,
            self::ACTION_TASK_ASSIGNED, self::ACTION_STATUS_CHANGED, self::ACTION_DEADLINE_CHANGED,
            self::ACTION_COMMENT_ADDED, self::ACTION_COMMENT_DELETED,
            self::ACTION_ATTACHMENT_UPLOADED, self::ACTION_ATTACHMENT_DELETED,
        ];
    }
}