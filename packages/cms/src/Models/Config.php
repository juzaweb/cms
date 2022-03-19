<?php

namespace Juzaweb\Models;

use Juzaweb\Facades\GlobalData;

/**
 * Juzaweb\Models\Config
 *
 * @property int $id
 * @property string $code
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Models\Config newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Models\Config newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Models\Config query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Models\Config whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Models\Config whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Models\Config whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Models\Config whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Models\Config whereValue($value)
 * @mixin \Eloquent
 * @property int|null $site_id
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereSiteId($value)
 */
class Config extends Model
{
    public $timestamps = false;
    protected $table = 'configs';
    protected $fillable = [
        'code',
        'value',
    ];

    public static function configs()
    {
        $configs = config('juzaweb.config');
        $configs = array_merge(GlobalData::get('configs'), $configs);
        return apply_filters('configs', $configs);
    }

    public static function getConfig($key, $default = null)
    {
        $value = self::where('code', '=', $key)->first();
        if (empty($value)) {
            return $default;
        }

        $value = $value->value;

        if (is_json($value)) {
            return json_decode($value, true);
        }

        return $value;
    }
}
