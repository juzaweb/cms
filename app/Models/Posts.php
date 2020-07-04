<?php

namespace App\Models;

use App\Traits\UseMetaSeo;
use App\Traits\UseSlug;
use App\Traits\UseThumbnail;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Posts
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $content
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $thumbnail
 * @property string|null $category
 * @property string|null $tags
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts whereThumbnail($value)
 */
class Posts extends Model
{
    use UseThumbnail, UseSlug, UseMetaSeo;
    
    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',
        'content',
        'status',
    ];
}
