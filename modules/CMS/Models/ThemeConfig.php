<?php

namespace Juzaweb\CMS\Models;

/**
 * Juzaweb\CMS\Models\ThemeConfig
 *
 * @property int $id
 * @property string $code
 * @property string $theme
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ThemeConfig newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ThemeConfig newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ThemeConfig query()
 * @method static \Illuminate\Database\Eloquent\Builder|ThemeConfig whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ThemeConfig whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ThemeConfig whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ThemeConfig whereTheme($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ThemeConfig whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ThemeConfig whereValue($value)
 * @mixin \Eloquent
 * @property int|null $site_id
 * @method static \Illuminate\Database\Eloquent\Builder|ThemeConfig whereSiteId($value)
 */
class ThemeConfig extends Model
{
    protected $table = 'theme_configs';
    protected $fillable = [
        'code',
        'theme',
        'value',
    ];
}
