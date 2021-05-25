<?php

namespace Modules\Movie\Models\PaidMembers;

use Illuminate\Database\Eloquent\Model;

/**
 * Modules\Movie\Models\PaidMembers\Package
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $days
 * @property string $price
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Core\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Package newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Package newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Package query()
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Package extends Model
{
    protected $table = 'packages';
    protected $fillable = [
        'name',
        'days',
        'price',
        'status',
    ];
    
    public function users() {
        return $this->hasMany('App\Core\User', 'package_id', 'id');
    }
}
