<?php

namespace App\Models;

use App\Traits\UseMetaSeo;
use App\Traits\UseSlug;
use App\Traits\UseThumbnail;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Pages
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $content
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pages newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pages newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pages query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pages whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pages whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pages whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pages whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pages whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pages whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pages whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $thumbnail
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pages whereThumbnail($value)
 */
class Pages extends Model
{
    use UseThumbnail, UseSlug, UseMetaSeo;
    
    protected $table = 'pages';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'content',
        'status',
    ];
}
