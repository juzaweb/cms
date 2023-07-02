<?php

namespace Juzaweb\Backend\Models;

use Juzaweb\CMS\Models\Model;

/**
 * Juzaweb\Backend\Models\PostRating
 *
 * @property int $id
 * @property int $post_id
 * @property string $client_ip
 * @property float $star
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Juzaweb\Backend\Models\Post $post
 * @method static \Illuminate\Database\Eloquent\Builder|PostRating newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostRating newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostRating query()
 * @method static \Illuminate\Database\Eloquent\Builder|PostRating whereClientIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostRating whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostRating whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostRating wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostRating whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostRating whereStar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostRating whereUpdatedAt($value)
 * @property int|null $site_id
 * @mixin \Eloquent
 */
class PostRating extends Model
{
    protected $table = 'post_ratings';

    protected $fillable = [
        'star',
        'client_ip',
        'post_id',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
}
