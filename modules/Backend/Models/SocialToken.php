<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Backend\Models;

use Juzaweb\CMS\Models\Model;
use Juzaweb\CMS\Models\User;

/**
 * Juzaweb\Backend\Models\SocialToken
 *
 * @property int $id
 * @property int $user_id
 * @property string $social_provider
 * @property string $social_id
 * @property string $social_token
 * @property string $social_refresh_token
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|SocialToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialToken whereSocialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialToken whereSocialProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialToken whereSocialRefreshToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialToken whereSocialToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialToken whereUserId($value)
 * @mixin \Eloquent
 */
class SocialToken extends Model
{
    public $timestamps = false;

    protected $table = 'social_tokens';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
