<?php

namespace App\Models\Leech;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Leech\LeechMovie
 *
 * @property int $id
 * @property int $leech_link_id
 * @property string $data
 * @property int $type 1: movie, 2: tv series
 * @property string|null $error
 * @property int $status 0: Failed, 1: Success, 2: Pending, 3: Downloading
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Leech\LeechMovie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Leech\LeechMovie newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Leech\LeechMovie query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Leech\LeechMovie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Leech\LeechMovie whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Leech\LeechMovie whereError($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Leech\LeechMovie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Leech\LeechMovie whereLeechLinkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Leech\LeechMovie whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Leech\LeechMovie whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Leech\LeechMovie whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LeechMovie extends Model
{

}
