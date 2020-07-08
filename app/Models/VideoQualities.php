<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\VideoQualities
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoQualities newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoQualities newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoQualities query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoQualities whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoQualities whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoQualities whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoQualities whereUpdatedAt($value)
 * @property int $default
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoQualities whereDefault($value)
 */
class VideoQualities extends Model
{
    protected $table = 'video_qualities';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'default'];
}
