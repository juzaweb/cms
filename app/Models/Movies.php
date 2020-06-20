<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Movies
 *
 * @property int $id
 * @property string $title
 * @property string $title_en
 * @property string $slug
 * @property string|null $description
 * @property string|null $stars
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
 */
class Movies extends Model
{
    //
}
