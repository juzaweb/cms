<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\VideoFiles
 *
 * @property int $id
 * @property int $server_id
 * @property int $movie_id
 * @property string $label
 * @property int $order
 * @property string $source
 * @property string $url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoFiles newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoFiles newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoFiles query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoFiles whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoFiles whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoFiles whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoFiles whereMovieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoFiles whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoFiles whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoFiles whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoFiles whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoFiles whereUrl($value)
 * @mixin \Eloquent
 */
class VideoFiles extends Model
{
    protected $table = 'video_files';
    protected $primaryKey = 'id';
    protected $fillable = [
        'label',
        'order',
        'source',
        'url',
        'status',
    ];
}
