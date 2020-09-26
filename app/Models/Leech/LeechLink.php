<?php

namespace App\Models\Leech;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Leech\LeechLink
 *
 * @property int $id
 * @property string $name
 * @property string $link
 * @property string $server
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Leech\LeechLink newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Leech\LeechLink newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Leech\LeechLink query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Leech\LeechLink whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Leech\LeechLink whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Leech\LeechLink whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Leech\LeechLink whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Leech\LeechLink whereServer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Leech\LeechLink whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LeechLink extends Model
{
    protected $table = 'leech_links';
    protected $fillable = [
        'name',
        'link',
        'server'
    ];
}
