<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\Languages
 *
 * @property int $id
 * @property string $key
 * @property string $name
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Languages newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Languages newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Languages query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Languages whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Languages whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Languages whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Languages whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Languages whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Languages whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Languages extends Model
{
    protected $table = 'languages';
    protected $primaryKey = 'id';
    protected $fillable = [
        'key',
        'name',
        'status'
    ];
}
