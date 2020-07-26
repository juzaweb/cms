<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\MovieRating;
use App\Models\Servers;
use App\Models\VideoFiles;
use App\Models\Genres;
use App\Models\Movies;

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
        $tags = $info->getTags();
        
        $related_movies = $info->getRelatedMovies(8);
        $player_id = $this->getFileVideo($info->id);
        $start = $info->getStarRating();
        
        $servers = Servers::where('movie_id', '=', $info->id)
            ->where('status', '=', 1)
            ->orderBy('order', 'asc')
            ->get();
        
        return view('themes.mymo.watch.index', [
            'title' => $info->meta_title,
            'description' => $info->meta_description,
            'keywords' => $info->keywords,
            'body_class' => 'post-template-default single single-post postid-24594 single-format-aside logged-in admin-bar no-customize-support wp-embed-responsive halimthemes halimmovies halim-corner-rounded',
            'related_movies' => $related_movies,
            'info' => $info,
            'player_id' => $player_id,
            'start' => $start,
            'genre' => $genre,
            'genres' => $genres,
            'countries' => $countries,
            'tags' => $tags,
            'servers' => $servers,
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
