<?php

namespace App\Http\Controllers\Frontend;

use App\Models\VideoFiles;
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
        
        $related_movies = $info->getRelatedMovies(8);
        
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
        $info = Movies::where('slug', '=', $slug)
            ->where('status', '=', 1)
            ->firstOrFail();
    
        $related_movies = $info->getRelatedMovies(8);
        
        return view('themes.mymo.watch.watch', [
            'title' => $info->meta_title,
            'description' => $info->meta_description,
            'keywords' => $info->keywords,
            'info' => $info,
            'related_movies' => $related_movies,
        ]);
    }
    
    public function getPlayer($vfile_id) {
        $file = VideoFiles::find($vfile_id);
        $files = $file->getFiles();
        
        if ($files) {
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
}
