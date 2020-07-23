<?php

namespace App\Http\Controllers\Frontend;

use App\Models\VideoFiles;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Genres;
use App\Models\Movies;
use App\Http\Controllers\Controller;
use App\Models\Tags;

class WatchController extends Controller
{
    public function index($slug) {
        $info = Movies::where('slug', '=', $slug)
            ->where('status', '=', 1)
            ->firstOrFail();
        
        $genre = Genres::where('status', '=', 1)
            ->whereIn('id', explode(',', $info->genres))
            ->first(['id', 'name', 'slug']);
    
        $genres = $info->getGenres();
        $countries = $info->getCountries();
        $tags = Tags::whereIn('id', explode(',', $info->tags))
            ->get(['id', 'name', 'slug']);
        
        $related_movies = $this->getRelatedMovies($info);
        
        return view('themes.mymo.watch.index', [
            'title' => $info->meta_title,
            'description' => $info->meta_description,
            'keywords' => $info->keywords,
            'info' => $info,
            'genre' => $genre,
            'genres' => $genres,
            'countries' => $countries,
            'tags' => $tags,
            'related_movies' => $related_movies,
        ]);
    }
    
    public function watch($slug) {
        $item = Movies::where('slug', '=', $slug)
            ->where('status', '=', 1)
            ->firstOrFail();
        
        return view('themes.mymo.watch.watch', [
            'item' => $item,
        ]);
    }
    
    public function getPlayer($vfile_id) {
        $file = VideoFiles::find($vfile_id);
        if ($file) {
            return response()->json([
                'data' => [
                    'status' => true,
                    'sources' => view('themes.mymo.data.player_script', [
                        'files' => $files,
                    ])->render(),
                ]
            ]);
        }
        
        return response()->json([
            'data' => [
                'status' => false,
            ]
        ]);
    }
    
    protected function getRelatedMovies(Movies $info) {
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
        ]);
        
        $query->where('status', '=', 1)
            ->where('id', '!=', $info->id);
    
        $query->where(function (Builder $builder) use ($info) {
            $builder->orWhereRaw('MATCH (name) AGAINST (? IN BOOLEAN MODE)', [full_text_wildcards($info->name)]);
            $builder->orWhereRaw('MATCH (other_name) AGAINST (? IN BOOLEAN MODE)', [full_text_wildcards($info->other_name)]);
        });
    
        $query->limit(8);
        
        return $query->get();
    }
}
