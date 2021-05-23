<?php

namespace App\Core\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Core\Models\ThemeConfigs
 *
 * @property int $id
 * @property string $code
 * @property string|null $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\ThemeConfigs newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\ThemeConfigs newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\ThemeConfigs query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\ThemeConfigs whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\ThemeConfigs whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\ThemeConfigs whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\ThemeConfigs whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\ThemeConfigs whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ThemeConfigs extends Model
{
    protected $table = 'theme_configs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'code',
        'content',
    ];
}
