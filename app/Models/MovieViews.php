<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MovieViews
 *
 * @property int $id
 * @property int $movie_id
 * @property int $views
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MovieViews newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MovieViews newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MovieViews query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MovieViews whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MovieViews whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MovieViews whereMovieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MovieViews whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MovieViews whereViews($value)
 * @mixin \Eloquent
 */
class MovieViews extends Model
{
    //
}
