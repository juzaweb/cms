<?php

namespace Plugins\Movie\Models\Movie;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Mymo\PostType\Traits\PostTypeModel;

class Movie extends Model
{
    use PostTypeModel;

    protected $fieldName = 'name';
    protected $thumbnailSize = '185x250';
    protected $fillable = [
        'name',
        'thumbnail',
        'other_name',
        'description',
        'short_description',
        'type_id',
        'poster',
        'rating',
        'release',
        'runtime',
        'video_quality',
        'trailer_link',
        'current_episode',
        'max_episode',
        'year',
        'status',
    ];

    protected $searchAttributes = [
        'name',
        'other_name'
    ];

    public function genres()
    {
        return $this->taxonomies()
            ->where('taxonomy', '=', 'countries');
    }

    public function fill(array $attributes)
    {
        if ($description = Arr::get($attributes, 'description')) {
            $attributes['short_description'] = sub_words(strip_tags($description), 15);
        }

        if ($release = Arr::get($attributes, 'release')) {
            $attributes['year'] = explode('-', $release)[0];
        }

        return parent::fill($attributes);
    }

    public function getGenres()
    {
        return $this->taxonomies()
            ->where('taxonomy', '=', 'genres')
            ->get();
    }

    public function getCountries()
    {
        return $this->genres()->get();
    }

    public function rating()
    {
        return $this->hasMany('Plugins\Movie\Models\Movie\MovieRating', 'movie_id', 'id');
    }
    
    public function servers()
    {
        return $this->hasMany('Plugins\Movie\Models\Video\VideoServers', 'movie_id', 'id');
    }
    
    public function comments()
    {
        return $this->hasMany('Plugins\Movie\Models\Movie\MovieComments', 'movie_id', 'id');
    }
    
    public function getViews()
    {
        if ($this->views < 1000) {
            return $this->views;
        }
        
        return round($this->views / 1000, 1) . 'K';
    }
    
    public function getPoster()
    {
        if ($this->poster) {
            return image_url($this->poster);
        }
        
        return $this->getThumbnail(false);
    }
    
    public function getTrailerLink()
    {
        if ($this->trailer_link) {
            return 'https://www.youtube.com/embed/' . get_youtube_id($this->trailer_link);
        }
        
        return '';
    }
    
    public function getServers($columns = ['id', 'name'])
    {
        return $this->servers()
            ->where('status', '=', 1)
            ->get($columns);
    }
    
    public function countRating()
    {
        return $this->rating()->count(['id']);
    }
    
    public function getStarRating()
    {
        $total = $this->rating()->sum('start');
        $count = $this->countRating();
        if ($count <= 0) {
            return 0;
        }
        return round($total * 5 / ($count * 5), 2);
    }
    
    public function getRelatedMovies(int $limit = 8)
    {
        $query = Movie::query();
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

        $genres = $this->taxonomies()
            ->where('taxonomy', '=', 'genres')
            ->pluck('id')
            ->toArray();

        if ($genres) {
            $query->where(function (Builder $builder) use ($genres) {
                foreach ($genres as $genre) {
                    $builder->orWhereHas('genres', function ($q) use ($genre) {
                        $q->where('id', '=', $genre);
                    });
                }
            });
        } else {
            $query->whereRaw('1=2');
        }
        
        $query->limit($limit);
    
        return $query->get();
    }
}
