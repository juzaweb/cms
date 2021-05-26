<?php

namespace Mymo\Core\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Mymo\Core\Models\ThemeConfig
 *
 * @property int $id
 * @property string $code
 * @property string|null $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\ThemeConfig newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\ThemeConfig newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\ThemeConfig query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\ThemeConfig whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\ThemeConfig whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\ThemeConfig whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\ThemeConfig whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\ThemeConfig whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ThemeConfig extends Model
{
    protected $table = 'theme_configs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'code',
        'content',
    ];
}
