<?php

namespace App\Models\LiveTV;

use App\Traits\UseMetaSeo;
use App\Traits\UseThumbnail;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LiveTV\LiveTvCategory
 *
 * @property int $id
 * @property string|null $thumbnail
 * @property string $name
 * @property string|null $description
 * @property string $slug
 * @property int $status
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $keywords
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTvCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTvCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTvCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTvCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTvCategory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTvCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTvCategory whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTvCategory whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTvCategory whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTvCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTvCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTvCategory whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTvCategory whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTvCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LiveTvCategory extends Model
{
    use UseMetaSeo, UseThumbnail;
    
    protected $table = 'live_tv_categories';
    protected $fillable = [
        'name',
        'description',
        'slug',
        'status',
    ];
}
