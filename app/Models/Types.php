<?php

namespace App\Models;

use App\Traits\UseMetaSeo;
use App\Traits\UseSlug;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Types
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Types newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Types newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Types query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Types whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Types whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Types whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Types whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Types whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Types whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Types whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Types whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Types whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Types whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Movie\Movies[] $movies
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
        return $this->hasMany('App\Models\Movie\Movies', 'id', 'movie_id');
    }
}
