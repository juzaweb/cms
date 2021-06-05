<?php

namespace Plugins\Movie\Models\Video;

use Illuminate\Database\Eloquent\Model;

/**
 * Plugins\Movie\Models\Video\VideoServers
 *
 * @property int $id
 * @property string $name
 * @property int $order
 * @property int $movie_id
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Video\VideoServers newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Video\VideoServers newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Video\VideoServers query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Video\VideoServers whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Video\VideoServers whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Video\VideoServers whereMovieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Video\VideoServers whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Video\VideoServers whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Video\VideoServers whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Video\VideoServers whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Plugins\Movie\Models\Movie\Movies $movie
 * @property-read \Illuminate\Database\Eloquent\Collection|\Plugins\Movie\Models\Video\VideoFiles[] $video_files
 * @property-read int|null $video_files_count
 */
class VideoServers extends Model
{
    protected $table = 'servers';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'order',
        'status'
    ];
    
    public function movie() {
        return $this->hasOne('Plugins\Movie\Models\Movie\Movies', 'id', 'movie_id');
    }
    
    public function video_files() {
        return $this->hasMany('Plugins\Movie\Models\Video\VideoFiles', 'server_id', 'id');
    }
}
