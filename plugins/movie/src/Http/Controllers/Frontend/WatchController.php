<?php

namespace Juzaweb\Movie\Http\Controllers\Frontend;

use Juzaweb\CMS\Http\Controllers\FrontendController;
use Juzaweb\Movie\Models\DownloadLink;
use Juzaweb\Movie\Models\Video\VideoServer;
use Juzaweb\Movie\Models\Movie\Movie;

class WatchController extends FrontendController
{
    public function index($slug) {
        $info = Movie::with([
            'taxonomies',
            'downloadLinks' => function ($q) {
                $q->where('status', '=', 1);
                $q->orderBy('order', 'ASC');
            }
        ])
            ->where('slug', '=', $slug)
            ->wherePublish()
            ->firstOrFail();
        
        return view('watch.index', [
            'title' => $info->name,
            'description' => $info->description,
            'banner' => $info->getPoster(),
            'body_class' => 'post-template-default single single-post postid-24594 single-format-aside logged-in admin-bar no-customize-support wp-embed-responsive mymothemes mymomovies mymo-corner-rounded',
            'related_movies' => $info->getRelatedMovies(8),
            'info' => $info,
            'player_id' => $this->_getFileVideo($info->id),
            'start' => $info->getStarRating(),
            'tags' => $info->taxonomies->where('taxonomy', 'tags'),
            'genres' => $info->taxonomies->where('taxonomy', 'genres'),
            'countries' => $info->taxonomies->where('taxonomy', 'genres'),
            'genre' => $info->taxonomies->where('taxonomy', 'genres')->first(),
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
        $server = VideoServer::where('status', '=', 1)
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
