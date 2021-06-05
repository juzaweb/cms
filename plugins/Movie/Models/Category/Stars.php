<?php

namespace Plugins\Movie\Models\Category;

use Mymo\Core\Traits\UseSlug;
use Mymo\Core\Traits\UseThumbnail;
use Illuminate\Database\Eloquent\Model;

/**
 * Plugins\Movie\Models\Category\Stars
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Category\Stars newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Category\Stars newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Category\Stars query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Category\Stars whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Category\Stars whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Category\Stars whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Category\Stars whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Category\Stars whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $description
 * @property string|null $thumbnail
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Category\Stars whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Category\Stars whereThumbnail($value)
 * @property string $type director/actor/writer
 * @property int $status
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Category\Stars whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Plugins\Movie\Models\Category\Stars whereType($value)
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
