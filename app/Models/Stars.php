<?php

namespace App\Models;

use App\Traits\UseSlug;
use App\Traits\UseThumbnail;
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
 * @property string|null $description
 * @property string|null $thumbnail
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stars whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stars whereThumbnail($value)
 * @property string $type director/actor/writer
 * @property int $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stars whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stars whereType($value)
 */
class Stars extends Model
{
    use UseThumbnail, UseSlug;
    
    protected $table = 'stars';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'slug',
        'description',
        'type',
        'status',
    ];
    
}
