<?php

namespace Juzaweb\CMS\Models;

use Juzaweb\CMS\Facades\GlobalData;

/**
 * Juzaweb\CMS\Models\Config
 *
 * @property int $id
 * @property string $code
 * @property string|null $value
 * @method static \Illuminate\Database\Eloquent\Builder|Config newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Config newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Config query()
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereValue($value)
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
