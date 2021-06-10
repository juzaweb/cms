<?php

namespace Plugins\Movie\Models\BlockIp;

use Illuminate\Database\Eloquent\Model;

/**
 * Plugins\Movie\Models\BlockIp\CountryName
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\BlockIp\CountryName newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\BlockIp\CountryName newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\BlockIp\CountryName query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\BlockIp\CountryName whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\BlockIp\CountryName whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\BlockIp\CountryName whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CountryName extends Model
{
    protected $table = 'country_names';
    protected $fillable = [
        'code',
        'name',
    ];
}
