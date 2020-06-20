<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Servers
 *
 * @property int $id
 * @property string $stream_key
 * @property string $name
 * @property string $source_type
 * @property string $file_source
 * @property string $file_url
 * @property int $order
 * @property int $movie_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Servers newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Servers newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Servers query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Servers whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Servers whereFileSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Servers whereFileUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Servers whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Servers whereMovieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Servers whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Servers whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Servers whereSourceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Servers whereStreamKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Servers whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Servers extends Model
{
    //
}
