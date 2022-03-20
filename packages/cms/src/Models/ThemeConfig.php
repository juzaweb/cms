<?php

namespace Juzaweb\Models;

class ThemeConfig extends Model
{
    protected $table = 'theme_configs';
    protected $fillable = [
        'code',
        'theme',
        'value',
    ];
}
