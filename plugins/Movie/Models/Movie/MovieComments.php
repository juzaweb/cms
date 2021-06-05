<?php

namespace Plugins\Movie\Models\Movie;

use Illuminate\Database\Eloquent\Model;

/**
 * Plugins\Movie\Models\Movie\MovieComments
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
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Movie\MovieComments newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Movie\MovieComments newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Movie\MovieComments publiced()
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Movie\MovieComments query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Movie\MovieComments whereApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Movie\MovieComments whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Movie\MovieComments whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Movie\MovieComments whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Movie\MovieComments whereMovieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Movie\MovieComments whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Movie\MovieComments whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Movie\MovieComments whereUserId($value)
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
        return $this->hasOne('App\Core\User', 'id', 'user_id');
    }
    
    public function scopePubliced($query) {
        return $query->where('status', '=', 1)
            ->where('approved', '=', 1);
    }
}
