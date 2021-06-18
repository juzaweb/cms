<?php

namespace Mymo\Core\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Mymo\Core\Models\Config
 *
 * @property int $id
 * @property string $code
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Config newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Config newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Config query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Config whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Config whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Config whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Config whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Config whereValue($value)
 * @mixin \Eloquent
 */
class Config extends Model
{
    public $timestamps = false;

    protected $table = 'configs';
    protected $fillable = [
        'code',
        'value'
    ];

    public static function getConfigs() {
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
            'tmdb_api_key',
            'google_recaptcha',
            'google_recaptcha_key',
            'google_recaptcha_secret',
            'comment_able',
            'comment_type',
            'comments_per_page',
            'comments_approval',
            'video_convert',
            'video_convert_quality',
            'hls_video',
            'player_watermark',
            'player_watermark_logo',
            'author_name',
            'fb_app_id',
            'movies_title',
            'movies_keywords',
            'movies_description',
            'movies_banner',
            'tv_series_title',
            'tv_series_keywords',
            'tv_series_description',
            'tv_series_banner',
            'blog_title',
            'blog_keywords',
            'blog_description',
            'blog_banner',
            'latest_movies_title',
            'latest_movies_keywords',
            'latest_movies_description',
            'latest_movies_banner',
            'facebook',
            'twitter',
            'pinterest',
            'youtube',
            'google_analytics',
            'stream3s_use',
            'stream3s_link',
            'stream3s_client_id',
            'stream3s_secret_key',
            'only_member_view',
            'block_ip_status',
            'block_ip_type',
            'block_ip_list',
        ];
    }
    
    public static function getConfig(string $key, $default = null) {
        $config = Config::where('code', '=', $key)->first(['value']);
        if ($config) {
            if (is_json($config->value)) {
                return json_decode($config->value, true);
            }
            return $config->value;
        }
    
        return $default;
    }
    
    public static function setConfig(string $key, $value = null) {
        $setting = null;
        if (is_string($value)) {
            $setting = $value;;
        }

        if (is_array($value)) {
            $setting = array_merge(get_config($key, []), $value);
            $setting = json_encode($setting);
        }

        $config = Config::firstOrNew(['code' => $key]);
        $config->code = $key;
        $config->value = $setting;
        return $config->save();
    }
}
