<?php

namespace Mymo\Core\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * Mymo\Core\Models\Languages
 *
 * @property int $id
 * @property string $key
 * @property string $name
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Languages newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Languages newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Languages query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Languages whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Languages whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Languages whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Languages whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Languages whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Languages whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $default
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\Languages whereDefault($value)
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
