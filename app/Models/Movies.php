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
 * @property string $name
 * @property string|null $other_name
 * @property string|null $thumbnail
 * @property string|null $poster
 * @property string $slug
 * @property string|null $description
 * @property string|null $short_description
 * @property string|null $actors
 * @property string|null $directors
 * @property string|null $writers
 * @property string|null $rating
 * @property string|null $release
 * @property int|null $year
 * @property string|null $countries
 * @property string $genres
 * @property int|null $type_id
 * @property string|null $tags
 * @property string|null $runtime
 * @property string|null $video_quality
 * @property string|null $trailer_link
 * @property int|null $current_episode
 * @property int|null $max_episode
 * @property int $tv_series
 * @property int $is_paid
 * @property int $status
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $keywords
 * @property int $views
 * @property int $created_by
 * @property int $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereActors($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereCountries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereCurrentEpisode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereDirectors($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereGenres($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereIsPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereMaxEpisode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereOtherName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies wherePoster($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereRelease($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereRuntime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereTrailerLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereTvSeries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereVideoQuality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereViews($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereWriters($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movies whereYear($value)
 * @mixin \Eloquent
 * @property-read int|null $rating_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Servers[] $servers
 * @property-read int|null $servers_count
 */
class Movies extends Model
{
    use UseThumbnail, UseSlug, UseMetaSeo, UseChangeBy;
    
    protected $table = 'movies';
    protected $primaryKey = 'id';
    protected $resize = '185x250';
    protected $fillable = [
        'name',
        'other_name',
        'description',
        'type_id',
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
    
    public function rating() {
        return $this->hasMany('App\Models\MovieRating', 'movie_id', 'id');
    }
    
    public function servers() {
        return $this->hasMany('App\Models\Servers', 'movie_id', 'id');
    }
    
    public function comments() {
        return $this->hasMany('App\Models\MovieComments', 'movie_id', 'id');
    }
    
    public function getViews() {
        if ($this->views < 1000) {
            return $this->views;
        }
        
        return round($this->views / 1000, 1) . 'K';
    }
    
    public function getPoster() {
        if ($this->poster) {
            return image_url($this->poster);
        }
        
        return $this->getThumbnail(false);
    }
    
    public function getGenres() {
        return Genres::where('status', '=', 1)
            ->whereIn('id', explode(',', $this->genres))
            ->get(['id', 'name', 'slug']);
    }
    
    public function getCountries() {
        return Countries::where('status', '=', 1)
            ->whereIn('id', explode(',', $this->countries))
            ->get(['id', 'name', 'slug']);
    }
    
    public function getTags() {
        return Tags::whereIn('id', explode(',', $this->tags))
            ->get(['id', 'name', 'slug']);
    }
    
    public function getServers($columns = ['id', 'name']) {
        return $this->servers()
            ->where('status', '=', 1)
            ->get($columns);
    }
    
    public function countRating() {
        return $this->rating()->count(['id']);
    }
    
    public function getStarRating() {
        $total = $this->rating()->sum('start');
        $count = $this->countRating();
        if ($count <= 0) {
            return 0;
        }
        return round($total * 5 / ($count * 5), 2);
    }
    
    public function getRelatedMovies(int $limit = 8) {
        $query = Movies::query();
        $query->select([
            'id',
            'name',
            'other_name',
            'short_description',
            'thumbnail',
            'slug',
            'views',
            'release',
            'video_quality',
            'genres',
            'countries',
        ]);
    
        $query->where('status', '=', 1)
            ->where('id', '!=', $this->id);
    
        $genres = explode(',', $this->genres);
        if ($genres) {
            $query->where(function (Builder $builder) use ($genres) {
                foreach ($genres as $genre) {
                    $builder->orWhereRaw('FIND_IN_SET(?, genres)', [$genre]);
                }
            });
        }
        else {
            $query->whereRaw('1=2');
        }
        
        $query->limit($limit);
    
        return $query->get();
    }
}
