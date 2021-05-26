<?php

namespace Mymo\Core\Models;

use Mymo\Core\Traits\UseChangeBy;
use Mymo\Core\Traits\UseMetaSeo;
use Mymo\Core\Traits\UseSlug;
use Mymo\Core\Traits\UseThumbnail;
use Illuminate\Database\Eloquent\Model;

/**
 * Mymo\Core\Models\Posts
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\Mymo\Core\Models\PostComments[] $comments
 * @property-read int|null $comments_count
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Posts newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Posts newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Posts query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Posts whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Posts whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Posts whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Posts whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Posts whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Posts whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Posts whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Posts whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Posts whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Posts whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Posts whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Posts whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Posts whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Posts whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Posts whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Posts whereViews($value)
 * @mixin \Eloquent
 */
class Posts extends Model
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
    
    public function comments() {
        return $this->hasMany('Mymo\Core\Models\PostComments', 'post_id', 'id');
    }
    
    public function created_by() {
        return $this->hasOne('Mymo\Core\Models\User', 'id', 'created_by');
    }
}
