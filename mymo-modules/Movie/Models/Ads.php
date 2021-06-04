<?php

namespace Modules\Movie\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modules\Movie\Models\Ads
 *
 * @property int $id
 * @property string $key
 * @property string $name
 * @property string|null $body
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Ads newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Ads newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Ads query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Ads whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Ads whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Ads whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Ads whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Ads whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Ads whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Movie\Models\Ads whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Ads extends Model
{
    protected $table = 'ads';
    protected $primaryKey = 'id';
    protected $fillable = [
        'body',
        'status'
    ];
}
