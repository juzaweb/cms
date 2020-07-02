<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Stars
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stars newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stars newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stars query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stars whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stars whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stars whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stars whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stars whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Stars extends Model
{
    protected $table = 'stars';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'slug',
        'description'
    ];
}
