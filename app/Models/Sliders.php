<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Sliders
 *
 * @property int $id
 * @property string $name
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sliders newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sliders newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sliders query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sliders whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sliders whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sliders whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sliders whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sliders whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Sliders extends Model
{
    protected $table = 'sliders';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
    ];
}
