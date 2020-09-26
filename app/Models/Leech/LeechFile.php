<?php

namespace App\Models\Leech;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Leech\LeechFile
 *
 * @property int $id
 * @property int $leech_id
 * @property string $label
 * @property string $original_url
 * @property string|null $local_path
 * @property string|null $error
 * @property int $status 0: Download failed, 1: Download success, 2: Download pending, 3: Downloading
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Leech\LeechFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Leech\LeechFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Leech\LeechFile query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Leech\LeechFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Leech\LeechFile whereError($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Leech\LeechFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Leech\LeechFile whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Leech\LeechFile whereLeechId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Leech\LeechFile whereLocalPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Leech\LeechFile whereOriginalUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Leech\LeechFile whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Leech\LeechFile whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LeechFile extends Model
{
    protected $table = 'leech_files';
    protected $fillable = [
        'label',
        'original_url',
        'local_path',
        'leech_link_id'
    ];
}
