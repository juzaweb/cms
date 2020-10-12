<?php

namespace App\Models\LiveTV;

use App\Traits\UseChangeBy;
use App\Traits\UseMetaSeo;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LiveTV\LiveTv
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $thumbnail
 * @property string|null $poster
 * @property int $category_id
 * @property int $status
 * @property int $is_paid
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $keywords
 * @property int $views
 * @property int $created_by
 * @property int $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTv newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTv newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTv query()
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTv whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTv whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTv whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTv whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTv whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTv whereIsPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTv whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTv whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTv whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTv whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTv wherePoster($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTv whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTv whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTv whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTv whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTv whereViews($value)
 * @mixin \Eloquent
 */
class LiveTv extends Model
{
    use UseChangeBy, UseMetaSeo;
    
    protected $table = 'live_tvs';
    protected $fillable = [
        'name',
        'description',
        'status',
        'category_id',
    ];
}
