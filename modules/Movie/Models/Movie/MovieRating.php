<?php

namespace App\Core\Models\Movie;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Core\Models\Movie\MovieRating
 *
 * @property int $id
 * @property int $movie_id
 * @property string $client_ip
 * @property float $start
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Movie\MovieRating newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Movie\MovieRating newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Movie\MovieRating query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Movie\MovieRating whereClientIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Movie\MovieRating whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Movie\MovieRating whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Movie\MovieRating whereMovieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Movie\MovieRating whereStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Movie\MovieRating whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MovieRating extends Model
{
    protected $table = 'movie_rating';
    protected $primaryKey = 'id';
    protected $fillable = [
        'start'
    ];
}
