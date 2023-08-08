<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Backend\Models;

use Juzaweb\CMS\Models\Model;

/**
 * Juzaweb\Backend\Models\PostLike
 *
 * @property int $id
 * @property int $post_id
 * @property int $user_id
 * @property string $client_ip
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PostLike newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostLike newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostLike query()
 * @method static \Illuminate\Database\Eloquent\Builder|PostLike whereClientIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostLike whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostLike whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostLike wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostLike whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostLike whereUserId($value)
 * @mixin \Eloquent
 */
class PostLike extends Model
{
    protected $table = 'post_likes';
    protected $fillable = [
        'post_id',
        'user_id',
        'client_ip'
    ];
}
