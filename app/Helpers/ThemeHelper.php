<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class ThemeHelper
{
    public static function getActiveTheme(): string
    {
        $theme = DB::table('settings')->where('key', 'theme_global')->value('value');
        return $theme ?: 'minimal';
    }
} 