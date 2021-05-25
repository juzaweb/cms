<?php

namespace Mymo\Core\Models;

use Mymo\Core\Traits\UseMetaSeo;
use Mymo\Core\Traits\UseSlug;
use Mymo\Core\Traits\UseThumbnail;
use Illuminate\Database\Eloquent\Model;

/**
 * Mymo\Core\Models\Pages
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $content
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Pages newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Pages newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Pages query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Pages whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Pages whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Pages whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Pages whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Pages whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Pages whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Pages whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $thumbnail
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Pages whereThumbnail($value)
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $keywords
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Pages whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Pages whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Pages whereMetaTitle($value)
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
