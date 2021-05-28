<?php

namespace Modules\Movie\Models\Category;

use Mymo\Core\Traits\UseMetaSeo;
use Mymo\Core\Traits\UseSlug;
use Mymo\Core\Traits\UseThumbnail;
use Illuminate\Database\Eloquent\Model;

/**
 * Modules\Movie\Models\Category\Genres
 *
 * @property int $id
 * @property string|null $thumbnail
 * @property string $name
 * @property string|null $description
 * @property string $slug
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Category\Genres newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Category\Genres newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Category\Genres query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Category\Genres whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Category\Genres whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Category\Genres whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Category\Genres whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Category\Genres whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Category\Genres whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Category\Genres whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Category\Genres whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $keywords
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Category\Genres whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Category\Genres whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Category\Genres whereMetaTitle($value)
 */
class Genres extends Model
{
    use UseThumbnail, UseSlug, UseMetaSeo;
    
    protected $table = 'genres';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'description',
        'status'
    ];
    
}
