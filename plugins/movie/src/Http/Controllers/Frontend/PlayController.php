<?php

namespace Juzaweb\Movie\Http\Controllers\Frontend;

use Juzaweb\CMS\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Cookie;
use Juzaweb\Backend\Models\Taxonomy;
use Juzaweb\Movie\Models\Movie\Movie;
use Juzaweb\Movie\Models\Movie\PostView;
use Juzaweb\Movie\Models\Video\VideoAds;
use Juzaweb\Movie\Models\Video\VideoFiles;

class PlayController extends FrontendController
{
    public function index($slug, $vid) {
        $info = Movie::where('slug', '=', $slug)
            ->wherePublish()
            ->firstOrFail();
        $genre = Taxonomy::whereIn('id', explode(',', $info->genres))
            ->first(['id', 'name', 'slug']);
        
        return view('watch.watch', [
            'title' => $info->meta_title,
            'description' => $info->meta_description,
            'keywords' => $info->keywords,
            'banner' => $info->getPoster(),
            'body_class' => 'post-template-default single single-post postid-24594 single-format-aside logged-in admin-bar no-customize-support wp-embed-responsive mymothemes mymomovies mymo-corner-rounded',
            'info' => $info,
            'player_id' => $vid,
            'start' => $info->getStarRating(),
            'genre' => $genre,
            'tags' => $info->getTags(),
            'servers' => $info->getServers(),
            'related_movies' => $info->getRelatedMovies(8),
        ]);
    }
    
    public function getPlayer($slug, $vid) {
        $movie = Movie::where('slug', '=', $slug)
            ->wherePublish()
            ->firstOrFail();
    
        if (get_config('only_member_view') == 1) {
            if (!\Auth::check()) {
                $file = new VideoFiles();
                $file->source = 'embed';
                $files[] = (object) ['file' => route('watch.no-view')];
                
                return response()->json([
                    'data' => [
                        'status' => true,
                        'sources' => view('data.player_script', [
                            'movie' => $movie,
                            'file' => $file,
                            'files' => $files,
                        ])->render(),
                    ]
                ]);
            }
        }
        
        $file = VideoFiles::find($vid);
        if ($file) {
            $files = $file->getFiles();
            $ads_exists = VideoAds::where('status', 1)->exists();
            return response()->json([
                'data' => [
                    'status' => true,
                    'sources' => view('data.player_script', [
                        'movie' => $movie,
                        'file' => $file,
                        'files' => $files,
                        'ads_exists' => $ads_exists,
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
    
    public function setMovieView($slug) {
        $movie = Movie::where('slug', '=', $slug)
            ->wherePublish()
            ->firstOrFail(['id', 'views']);
    
        $views = $movie->views;
        $viewed = Cookie::get('viewed');
        if ($viewed) {
            $viewed = json_decode($viewed, true);
            
            if (in_array($movie->id, $viewed)) {
                return response()->json([
                    'view' => $views,
                ]);
            }
        }
        
        if (empty($viewed)) {
            $viewed = [];
        }
    
        $views = $movie->views + 1;
        $this->setView($movie->id);
        
        $viewed[] = $movie->id;
        Cookie::queue('viewed', json_encode($viewed), 1440);
        
        Movie::where('id', '=', $movie->id)
            ->update([
                'views' => $views
            ]);
        
        return response()->json([
            'view' => $views,
        ]);
    }
    
    protected function setView($movie_id) {
        $model = PostView::firstOrNew([
            'movie_id' => $movie_id,
            'day' => date('Y-m-d'),
        ]);
        $model->movie_id = $movie_id;
        $model->views = empty($model->views) ? 1 : $model->views + 1;
        $model->day = date('Y-m-d');
        return $model->save();
    }
}
