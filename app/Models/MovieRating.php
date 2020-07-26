<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MovieRating
 *
 * @property int $id
 * @property int $movie_id
 * @property string $client_ip
 * @property float $start
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MovieRating newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MovieRating newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MovieRating query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MovieRating whereClientIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MovieRating whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MovieRating whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MovieRating whereMovieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MovieRating whereStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MovieRating whereUpdatedAt($value)
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
