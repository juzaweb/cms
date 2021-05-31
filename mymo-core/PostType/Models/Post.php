<?php

namespace Mymo\PostType\Models;

use Mymo\Core\Traits\UseChangeBy;
use Mymo\Core\Traits\UseMetaSeo;
use Mymo\Core\Traits\UseSlug;
use Mymo\Core\Traits\UseThumbnail;
use Illuminate\Database\Eloquent\Model;

/**
 * Mymo\PostType\Models\Post
 *
 * @property int $id
 * @property string $title
 * @property string|null $thumbnail
 * @property string $slug
 * @property string|null $content
 * @property string|null $category
 * @property string|null $tags
 * @property int $status
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $keywords
 * @property int $views
 * @property \Mymo\Core\Models\User|null $created_by
 * @property int $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Mymo\PostType\Models\Comment[] $comments
 * @property-read int|null $comments_count
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\PostType\Models\Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\PostType\Models\Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\PostType\Models\Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\PostType\Models\Post whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\PostType\Models\Post whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\PostType\Models\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\PostType\Models\Post whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\PostType\Models\Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\PostType\Models\Post whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\PostType\Models\Post whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\PostType\Models\Post whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\PostType\Models\Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\PostType\Models\Post whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\PostType\Models\Post whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\PostType\Models\Post whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\PostType\Models\Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\PostType\Models\Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\PostType\Models\Post whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\PostType\Models\Post whereViews($value)
 * @mixin \Eloquent
 */
class Post extends Model
{
    use UseThumbnail, UseSlug, UseMetaSeo, UseChangeBy;
    
    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',
        'content',
        'status',
        'views'
    ];
    
    public function comments()
    {
        return $this->hasMany('Mymo\PostType\Models\PostComment', 'post_id', 'id');
    }
    
    public function created_by()
    {
        return $this->hasOne('Mymo\Core\Models\User', 'id', 'created_by');
    }
}
