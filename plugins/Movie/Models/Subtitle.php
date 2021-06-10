<?php

namespace Plugins\Movie\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Plugins\Movie\Models\Subtitle
 *
 * @property int $id
 * @property string $label
 * @property string $url
 * @property int $order
 * @property int $status
 * @property int $file_id
 * @property int $movie_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Subtitle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subtitle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subtitle query()
 * @method static \Illuminate\Database\Eloquent\Builder|Subtitle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subtitle whereFileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subtitle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subtitle whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subtitle whereMovieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subtitle whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subtitle whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subtitle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subtitle whereUrl($value)
 * @mixin \Eloquent
 */
class Subtitle extends Model
{
    protected $table = 'subtitles';
    protected $fillable = [
        'label',
        'url',
        'order',
        'status'
    ];
}
