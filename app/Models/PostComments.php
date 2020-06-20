<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PostComments
 *
 * @property int $id
 * @property int $movie_id
 * @property int $user_id
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostComments newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostComments newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostComments query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostComments whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostComments whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostComments whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostComments whereMovieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostComments whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostComments whereUserId($value)
 * @mixin \Eloquent
 */
class PostComments extends Model
{
    //
}
