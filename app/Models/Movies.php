<?php

namespace App\Models;

use App\Traits\UseChangeBy;
use App\Traits\UseMetaSeo;
use App\Traits\UseSlug;
use App\Traits\UseThumbnail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Movies
 *
 * @property int $id
 * @property string $title
 * @property string $title_en
 * @property string $slug
 * @property string|null $description
 * @property string|null $directors
 * @property string|null $writers
 * @property string|null $rating
 * @property string|null $release
 * @property string|null $countries
 * @property string|null $genres
 * @property string|null $runtime
 * @property string|null $video_quality
 * @property string|null $trailer_link
 * @property int|null $current_episode
 * @property int|null $max_episode
 * @property int $is_paid
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereCountries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereCurrentEpisode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereDirectors($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereGenres($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereIsPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereMaxEpisode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereRelease($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereRuntime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereStars($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereTitleEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereTrailerLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereVideoQuality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereWriters($value)
 * @mixin \Eloquent
 * @property string $name
 * @property string|null $name_en
 * @property string|null $thumbnail
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereThumbnail($value)
 * @property int $tv_series
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereTvSeries($value)
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $keywords
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereMetaTitle($value)
 * @property string|null $other_name
 * @property string|null $poster
 * @property string|null $actors
 * @property string|null $tags
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereActors($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereOtherName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies wherePoster($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereTags($value)
 * @property int $views
 * @property int $created_by
 * @property int $updated_by
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereViews($value)
 */
class Movies extends Model
{
    use UseThumbnail, UseSlug, UseMetaSeo, UseChangeBy;
    
    protected $table = 'movies';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'other_name',
        'description',
        'thumbnail',
        'poster',
        'rating',
        'release',
        'runtime',
        'video_quality',
        'trailer_link',
        'current_episode',
        'max_episode',
        'status',
    ];
    
    public static function getPopular($date) {
        return Movies::select([
            'id',
            'name',
            'thumbnail',
        ])
            ->where('status', '=', 1)
            ->whereIn('id', function (Builder $builder) use ($date) {
                $builder->select(['movie_id'])
                    ->from('movie_views')
                    ->where('created_at', 'like', $date . '%');
            })
            ->limit(5)
            ->get();
    }
}
