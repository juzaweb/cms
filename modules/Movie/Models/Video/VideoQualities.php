<?php

namespace Modules\Movie\Models\Video;

use Illuminate\Database\Eloquent\Model;

/**
 * Modules\Movie\Models\Video\VideoQualities
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Video\VideoQualities newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Video\VideoQualities newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Video\VideoQualities query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Video\VideoQualities whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Video\VideoQualities whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Video\VideoQualities whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Video\VideoQualities whereUpdatedAt($value)
 * @property int $default
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Video\VideoQualities whereDefault($value)
 */
class VideoQualities extends Model
{
    protected $table = 'video_qualities';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'default'];
}
