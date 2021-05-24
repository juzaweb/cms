<?php

namespace App\Core\Models\Category;

use App\Core\Traits\UseMetaSeo;
use App\Core\Traits\UseSlug;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Core\Models\Category\Types
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Category\Types newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Category\Types newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Category\Types query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Category\Types whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Category\Types whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Category\Types whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Category\Types whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Category\Types whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Category\Types whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Category\Types whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Category\Types whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Category\Types whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Category\Types whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Core\Models\Movie\Movies[] $movies
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
        return $this->hasMany('App\Core\Models\Movie\Movies', 'id', 'movie_id');
    }
}
