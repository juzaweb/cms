<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Servers
 *
 * @property int $id
 * @property string $name
 * @property int $order
 * @property int $movie_id
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Servers newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Servers newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Servers query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Servers whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Servers whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Servers whereMovieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Servers whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Servers whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Servers whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Servers whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Servers extends Model
{
    protected $table = 'servers';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'order',
        'status'
    ];
    
    public function movie() {
        return $this->belongsTo('App\Models\Movies', 'movie_id', 'id');
    }
}
