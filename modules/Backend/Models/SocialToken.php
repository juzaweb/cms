<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Juzaweb\CMS\Models\Model;
use Juzaweb\CMS\Models\User;
use Juzaweb\Network\Traits\RootNetworkModel;

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
 * @property int|null $site_id
 * @method static \Illuminate\Database\Eloquent\Builder|SocialToken whereSiteId($value)
 * @mixin \Eloquent
 */
class SocialToken extends Model
{
    use RootNetworkModel;

    public $timestamps = false;

    protected $table = 'social_tokens';
    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
