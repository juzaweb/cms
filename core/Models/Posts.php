<?php

namespace App\Models;

use App\Traits\UseChangeBy;
use App\Traits\UseMetaSeo;
use App\Traits\UseSlug;
use App\Traits\UseThumbnail;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Posts
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
 * @property \App\User|null $created_by
 * @property int $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PostComments[] $comments
 * @property-read int|null $comments_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts whereViews($value)
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
        return $this->hasMany('App\Models\PostComments', 'post_id', 'id');
    }
    
    public function created_by() {
        return $this->hasOne('App\User', 'id', 'created_by');
    }
}
