<?php

namespace App\Core\Models;

use App\Core\Traits\UseMetaSeo;
use App\Core\Traits\UseSlug;
use App\Core\Traits\UseThumbnail;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Core\Models\Pages
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $content
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Pages newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Pages newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Pages query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Pages whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Pages whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Pages whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Pages whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Pages whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Pages whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Pages whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $thumbnail
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Pages whereThumbnail($value)
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $keywords
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Pages whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Pages whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Pages whereMetaTitle($value)
 */
class Pages extends Model
{
    use UseThumbnail, UseSlug, UseMetaSeo;
    
    protected $table = 'pages';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'content',
        'status',
    ];
}
