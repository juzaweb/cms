<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MovieComments
 *
 * @property int $id
 * @property int $user_id
 * @property int $movie_id
 * @property string $content
 * @property int $approved
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MovieComments newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MovieComments newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MovieComments publiced()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MovieComments query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MovieComments whereApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MovieComments whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MovieComments whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MovieComments whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MovieComments whereMovieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MovieComments whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MovieComments whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MovieComments whereUserId($value)
 * @mixin \Eloquent
 */
class MovieComments extends Model
{
    protected $table = 'movie_comments';
    protected $primaryKey = 'id';
    protected $fillable = [
        'content',
        'user_id'
    ];
    
    public function user() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
    
    public function scopePubliced($query) {
        return $query->where('status', '=', 1)
            ->where('approved', '=', 1);
    }
}
