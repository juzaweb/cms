<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Countries
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Countries newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Countries newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Countries query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Countries whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Countries whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Countries whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Countries whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Countries whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Countries whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Countries extends Model
{
    //
}
