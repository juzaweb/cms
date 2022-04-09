<?php

namespace Juzaweb\Movie\Models;

use Illuminate\Database\Eloquent\Model;
use Juzaweb\CMS\Traits\ResourceModel;

/**
 * Juzaweb\Movie\Models\Subtitle
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
 * @method static \Illuminate\Database\Eloquent\Builder|Subtitle whereFilter($params = [])
 */
class Subtitle extends Model
{
    use ResourceModel;

    protected $table = 'subtitles';
    protected $fieldName = 'label';
    protected $fillable = [
        'label',
        'url',
        'order',
        'status',
        'file_id',
        'movie_id'
    ];
}
