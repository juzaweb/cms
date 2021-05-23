<?php

namespace App\Models\BlockIp;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BlockIp\CountryName
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlockIp\CountryName newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlockIp\CountryName newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlockIp\CountryName query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlockIp\CountryName whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlockIp\CountryName whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlockIp\CountryName whereUpdatedAt($value)
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
