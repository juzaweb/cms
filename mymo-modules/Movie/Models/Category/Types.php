<?php

namespace Modules\Movie\Models\Category;

use Mymo\Core\Traits\UseMetaSeo;
use Mymo\Core\Traits\UseSlug;
use Illuminate\Database\Eloquent\Model;

/**
 * Modules\Movie\Models\Category\Types
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property int $status
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $keywords
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Category\Types newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Category\Types newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Category\Types query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Category\Types whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Category\Types whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Category\Types whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Category\Types whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Category\Types whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Category\Types whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Category\Types whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Category\Types whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Category\Types whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Category\Types whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Modules\Movie\Models\Movie\Movies[] $movies
 * @property-read int|null $movies_count
 */
class Types extends Model
{
    use UseMetaSeo, UseSlug;
    
    protected $table = 'types';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
    ];
    
    public function movies() {
        return $this->hasMany('Modules\Movie\Models\Movie\Movies', 'id', 'movie_id');
    }
}
