<?php

namespace Plugins\Movie\Models\Video;

use Illuminate\Database\Eloquent\Model;

/**
 * Plugins\Movie\Models\Video\VideoServer
 *
 * @property int $id
 * @property string $name
 * @property int $order
 * @property int $movie_id
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Video\VideoServer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Video\VideoServer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Video\VideoServer query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Video\VideoServer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Video\VideoServer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Video\VideoServer whereMovieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Video\VideoServer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Video\VideoServer whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Video\VideoServer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Video\VideoServer whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Plugins\Movie\Models\Movie\Movie $movie
 * @property-read \Illuminate\Database\Eloquent\Collection|\Plugins\Movie\Models\Video\VideoFiles[] $video_files
 * @property-read int|null $video_files_count
 */
class VideoServer extends Model
{
    protected $table = 'servers';
    protected $fillable = [
        'name',
        'order',
        'status'
    ];
    
    public function movie() {
        return $this->hasOne('Plugins\Movie\Models\Movie\Movie', 'id', 'movie_id');
    }
    
    public function video_files() {
        return $this->hasMany('Plugins\Movie\Models\Video\VideoFiles', 'server_id', 'id');
    }
}
