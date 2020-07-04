<?php

namespace App\Models;

use App\Traits\UseMetaSeo;
use App\Traits\UseSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
 * @property string|null $description
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Countries whereDescription($value)
 */
class Countries extends Model
{
    use UseSlug, UseMetaSeo;
    
    protected $table = 'countries';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'description', 'status'];
}
