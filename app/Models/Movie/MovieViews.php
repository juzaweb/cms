<?php

namespace App\Models\Movie;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Movie\MovieViews
 *
 * @property int $id
 * @property int $movie_id
 * @property int $views
 * @property string $day
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movie\MovieViews newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movie\MovieViews newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movie\MovieViews query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movie\MovieViews whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movie\MovieViews whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movie\MovieViews whereMovieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movie\MovieViews whereViews($value)
 * @mixin \Eloquent
 */
class MovieViews extends Model
{
    protected $table = 'movie_views';
    protected $primaryKey = 'id';
    protected $fillable = [
        'views'
    ];
    public $timestamps = false;
}
