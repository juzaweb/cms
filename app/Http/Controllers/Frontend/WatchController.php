<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Video\VideoServers;
use App\Models\Category\Genres;
use App\Models\Movie\Movies;

class WatchController extends Controller
{
    public function index($slug) {
        $info = Movies::where('slug', '=', $slug)
            ->where('status', '=', 1)
            ->firstOrFail();
        
        $genre = Genres::where('status', '=', 1)
            ->whereIn('id', explode(',', $info->genres))
            ->first(['id', 'name', 'slug']);
        
        return view('themes.mymo.watch.index', [
            'title' => $info->meta_title,
            'description' => $info->meta_description,
            'keywords' => $info->keywords,
            'banner' => $info->getPoster(),
            'body_class' => 'post-template-default single single-post postid-24594 single-format-aside logged-in admin-bar no-customize-support wp-embed-responsive mymothemes mymomovies mymo-corner-rounded',
            'related_movies' => $info->getRelatedMovies(8),
            'info' => $info,
            'player_id' => $this->_getFileVideo($info->id),
            'start' => $info->getStarRating(),
            'genre' => $genre,
            'genres' => $info->getGenres(),
            'countries' => $info->getCountries(),
            'tags' => $info->getTags(),
            'servers' => $info->getServers(),
        ]);
    }
    
    private function _getFileVideo($movie_id) {
        $server = VideoServers::where('status', '=', 1)
            ->where('movie_id', '=', $movie_id)
            ->orderBy('order', 'asc')
            ->first(['id', 'movie_id']);
        
        if (empty($server)) {
            return 0;
        }
        
        $video = $server->video_files()
            ->orderBy('order', 'asc')
            ->orderBy('id', 'asc')
            ->first(['id']);
        
        if (empty($video)) {
            return 0;
        }
    
        return $video->id;
    }
}
