<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Comments
 *
 * @property int $id
 * @property int $user_id
 * @property int $movie_id
 * @property string $content
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comments newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comments newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comments query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comments whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comments whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comments whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comments whereMovieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comments whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comments whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comments whereUserId($value)
 * @mixin \Eloquent
 */
class Comments extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'id';
    protected $fillable = ['content', 'status'];
    
    public function user()
    {
        return $this->hasOne('App\User');
    }
}
