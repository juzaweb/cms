<?php

namespace Juzaweb\Models;

use Juzaweb\Facades\GlobalData;

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
