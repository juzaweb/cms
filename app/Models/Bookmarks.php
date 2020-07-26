<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Bookmarks
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bookmarks newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bookmarks newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bookmarks query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $movie_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bookmarks whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bookmarks whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bookmarks whereMovieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bookmarks whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bookmarks whereUserId($value)
 */
class Bookmarks extends Model
{
    //
}
