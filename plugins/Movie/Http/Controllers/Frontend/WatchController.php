<?php

namespace Plugins\Movie\Http\Controllers\Frontend;

use Mymo\Core\Http\Controllers\FrontendController;
use Plugins\Movie\Models\DownloadLink;
use Plugins\Movie\Models\Video\VideoServers;
use Plugins\Movie\Models\Category\Genres;
use Plugins\Movie\Models\Movie\Movie;

class WatchController extends FrontendController
{
    public function index($slug) {
        $info = Movie::where('slug', '=', $slug)
            ->where('status', '=', 1)
            ->firstOrFail();
        
        $genre = Genres::where('status', '=', 1)
            ->whereIn('id', explode(',', $info->genres))
            ->first(['id', 'name', 'slug']);
        
        $download_links = DownloadLink::where('movie_id', '=', $info->id)
            ->where('status', '=', 1)
            ->orderBy('order', 'ASC')
            ->get();
        
        return view('watch.index', [
            'title' => $info->meta_title,
            'description' => $info->meta_description,
            'keywords' => $info->keywords,
            'banner' => $info->getPoster(),
            'download_links' => $download_links,
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
    
    public function download($link_id) {
        $download = DownloadLink::find($link_id);
        if (empty($download) || $download->status != 1) {
            return abort(404);
        }
        
        return redirect()->to($download->url);
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
