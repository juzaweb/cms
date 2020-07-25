<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Servers;
use App\Models\VideoFiles;
use App\Models\Genres;
use App\Models\Movies;
use App\Http\Controllers\Controller;
use App\Models\Tags;
use Illuminate\Http\Request;

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
        $player_id = $this->getFileVideo($info->id);
        
        return view('themes.mymo.watch.index', [
            'title' => $info->meta_title,
            'description' => $info->meta_description,
            'keywords' => $info->keywords,
            'body_class' => 'post-template-default single single-post postid-24594 single-format-aside logged-in admin-bar no-customize-support wp-embed-responsive halimthemes halimmovies halim-corner-rounded',
            'related_movies' => $related_movies,
            'info' => $info,
            'player_id' => $player_id,
            'genre' => $genre,
            'genres' => $genres,
            'countries' => $countries,
            'tags' => $tags,
        ]);
    }
    
    public function watch($slug, $vid) {
        $info = Movies::where('slug', '=', $slug)
            ->where('status', '=', 1)
            ->firstOrFail();
        $genre = Genres::where('status', '=', 1)
            ->whereIn('id', explode(',', $info->genres))
            ->first(['id', 'name', 'slug']);
        $tags = Tags::whereIn('id', explode(',', $info->tags))
            ->get(['id', 'name', 'slug']);
        
        $related_movies = $info->getRelatedMovies(8);
        
        return view('themes.mymo.watch.watch', [
            'title' => $info->meta_title,
            'description' => $info->meta_description,
            'keywords' => $info->keywords,
            'body_class' => 'post-template-default single single-post postid-24594 single-format-aside logged-in admin-bar no-customize-support wp-embed-responsive halimthemes halimmovies halim-corner-rounded',
            'info' => $info,
            'genre' => $genre,
            'tags' => $tags,
            'related_movies' => $related_movies,
        ]);
    }
    
    public function getPlayer($slug, Request $request) {
        $vfile_id = $request->post('file_id');
        
        $file = VideoFiles::find($vfile_id);
        if ($file) {
            
            $files = $file->getFiles();
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
    
    protected function getFileVideo($movie_id) {
        $server = Servers::where('status', '=', 1)
            ->where('movie_id', '=', $movie_id)
            ->orderBy('order', 'asc')
            ->first(['id']);
        if (empty($server)) {
            return 0;
        }
        
        $video = VideoFiles::where('server_id', '=', $server->id)
            ->orderBy('order', 'asc')
            ->first(['id']);
        
        if (empty($video)) {
            return 0;
        }
    
        return $video->id;
    }
}
