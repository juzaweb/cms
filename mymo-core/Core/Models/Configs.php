<?php

namespace Mymo\Core\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Mymo\Core\Models\Configs
 *
 * @property int $id
 * @property string $code
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Configs newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Configs newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Configs query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Configs whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Configs whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Configs whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Configs whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Configs whereValue($value)
 * @mixin \Eloquent
 */
class Configs extends Model
{
    protected $table = 'configs';
    protected $primaryKey = 'id';
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
        $config = Configs::where('code', '=', $key)->first(['value']);
        if ($config) {
            return $config->value;
        }
    
        return $default;
    }
    
    public static function setConfig(string $key, string $value = null) {
        $config = Configs::firstOrNew(['code' => $key]);
        $config->code = $key;
        $config->value = $value;
        return $config->save();
    }
    
}
