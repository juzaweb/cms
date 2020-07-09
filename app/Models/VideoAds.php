<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\VideoAds
 *
 * @property int $id
 * @property string $name
 * @property string $title
 * @property string $url
 * @property string|null $description
 * @property string $video_url
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoAds newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoAds newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoAds query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoAds whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoAds whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoAds whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoAds whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoAds whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoAds whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoAds whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoAds whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoAds whereVideoUrl($value)
 * @mixin \Eloquent
 */
class VideoAds extends Model
{
    protected $table = 'video_ads';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'title',
        'url',
        'description',
        'video_url',
    ];
}
