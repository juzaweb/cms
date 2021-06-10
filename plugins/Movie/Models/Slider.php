<?php

namespace Plugins\Movie\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Plugins\Movie\Models\Slider
 *
 * @property int $id
 * @property string $name
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Slider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Slider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Slider query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Slider whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Slider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Slider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Slider whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Slider whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Slider extends Model
{
    protected $table = 'sliders';
    protected $fillable = [
        'name',
    ];
}
