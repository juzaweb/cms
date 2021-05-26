<?php

namespace Mymo\Core\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Mymo\Core\Models\PostComments
 *
 * @property int $id
 * @property int $user_id
 * @property int $movie_id
 * @property string $content
 * @property int $approved
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\PostComments newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\PostComments newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\PostComments query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\PostComments whereApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\PostComments whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\PostComments whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\PostComments whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\PostComments whereMovieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\PostComments whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\PostComments whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\PostComments whereUserId($value)
 * @mixin \Eloquent
 */
class PostComments extends Model
{
    //
}
