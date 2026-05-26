<?php

namespace App\Support\Constants;

class UserPreferenceConstants
{
    public const THEME_LIGHT = 'light';
    public const THEME_DARK = 'dark';
    public const THEME_SYSTEM = 'system';

    public const TASK_VIEW_LIST = 'list';
    public const TASK_VIEW_BOARD = 'board';

    public static function allThemes(): array
    {
        return [
            self::THEME_LIGHT, 
            self::THEME_DARK, 
            self::THEME_SYSTEM
        ];
    }

    public static function allTaskViews(): array
    {
        return [
            self::TASK_VIEW_LIST, 
            self::TASK_VIEW_BOARD
        ];
    }
}