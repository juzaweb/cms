<?php

namespace Juzaweb\Models;

use Illuminate\Support\Facades\Cache;

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
 */
class Config extends Model
{
    public $timestamps = false;
    protected $table = 'configs';
    protected $fillable = [
        'code',
        'value',
    ];

    public static function getConfigs()
    {
        return [
            'title',
            'description',
            'keywords',
            'banner',
            'logo',
            'icon',
            'banner',
            'user_registration',
            'user_verification',
            'google_recaptcha',
            'google_recaptcha_key',
            'google_recaptcha_secret',
            'comment_able',
            'comment_type',
            'comments_per_page',
            'comments_approval',
            'author_name',
            'facebook',
            'twitter',
            'pinterest',
            'youtube',
            'google_analytics',
        ];
    }

    public static function getConfig($key, $default = null)
    {
        $value = Cache::rememberForever('jw_config.' . $key, function () use ($key, $default) {
            $config = Config::where('code', '=', $key)->first(['value']);

            if (empty($value)) {
                return $default;
            }

            return $config->value;
        });

        if (is_json($value)) {
            return json_decode($value, true);
        }

        return $value;
    }

    public static function setConfig($key, $value = null)
    {
        if (is_array($value)) {
            $value = array_merge(get_config($key, []), $value);
            $value = json_encode($value);
        }

        $config = Config::firstOrNew(['code' => $key]);
        $config->code = $key;
        $config->value = $value;
        $config->save();

        Cache::forever('jw_config.' . $key, $value);

        return $config;
    }
}
