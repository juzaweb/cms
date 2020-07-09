<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Configs
 *
 * @property int $id
 * @property string $key
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Configs newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Configs newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Configs query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Configs whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Configs whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Configs whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Configs whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Configs whereValue($value)
 * @mixin \Eloquent
 */
class Configs extends Model
{
    protected $table = 'configs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name'
    ];
    
    public static function getConfig(string $key) {
        $config = Configs::firstOrNew(['key' => $key]);
        return $config->value;
    }
    
    public static function setConfig(string $key, string $value = null) {
        $config = Configs::firstOrNew(['key' => $key]);
        $config->key = $key;
        $config->value = $value;
        return $config->save();
    }
    
    public static function getConfigs() {
        return [
            'title',
            'description',
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
            'mail_host',
            'mail_driver',
            'mail_port',
            'mail_username',
            'mail_password',
            'mail_from_name',
            'mail_from_address',
        ];
    }
}
