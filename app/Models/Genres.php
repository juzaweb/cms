<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Genres
 *
 * @property int $id
 * @property string|null $thumbnail
 * @property string $name
 * @property string|null $description
 * @property string $slug
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Genres newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Genres newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Genres query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Genres whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Genres whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Genres whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Genres whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Genres whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Genres whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Genres whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Genres whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Genres extends Model
{
    protected $table = 'genres';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'description',
        'status'
    ];
    
    public function getThumbnail() {
        if ($this->thumbnail) {
        
        }
    }
}
