<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Countries;
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
    
    public function getPlayer() {
        return '{"data":{"status":true,"sources":"            <script>\r\n                var resumeId = encodeURI(\'5d1d90fdec293317a9cd9bb7c444ead9\'),\r\n                    playerInstance = jwplayer(\'ajax-player\');\r\n                if(typeof playerInstance != \'undefined\'){\r\n                    playerInstance.setup({\r\n                        key: \"ITWMv7t88JGzI0xPwW8I0+LveiXX9SWbfdmt0ArUSyc=\",\r\n                        primary: \"html5\",\r\n                        playlist: [{\r\n                            title: \"\u0110\u1eb9p Trai L\u00e0 S\u1ed1 1\",\r\n                            image: \"\/wp-content\/uploads\/2020\/05\/dep-trai-la-so-1-15425-poster.jpg\",\r\n                            sources: [{\"label\":\"720p\",\"type\":\"mp4\",\"file\":\"http:\\\/\\\/api.3s.live\\\/api\\\/redirect?file=0a6ea0021431d9de3f57c7dc86e51af2c715e3af0b005643a13535d44abf20412a3e15fe4732dbc1be3b195470d8b048&label=720p\"},{\"label\":\"360p\",\"type\":\"mp4\",\"file\":\"http:\\\/\\\/api.3s.live\\\/api\\\/redirect?file=0a6ea0021431d9de3f57c7dc86e51af2c715e3af0b005643a13535d44abf20412a3e15fe4732dbc1be3b195470d8b048&label=360p\"}],\r\n                            tracks: [],\r\n                            captions: {\r\n                                color: \"#fff\",\r\n                                fontSize: 14,\r\n                                backgroundOpacity: 0,\r\n                                edgeStyle: \"raised\"\r\n                            }\r\n                        }],\r\n                                                logo: {\r\n                            file: \"\/wp-content\/uploads\/2019\/05\/logo-xemphimplus.png\",\r\n                            link: \"https:\/\/xemphimplus.net\/\",\r\n                            hide: \"true\",\r\n                            target: \"_blank\",\r\n                            position: \"top-right\",\r\n                        },\r\n                                                                        floating: {\r\n                            dismissible: true\r\n                        },\r\n                                                                        autoPause: {\r\n                            viewability: true,\r\n                            pauseAds: true\r\n                        },\r\n                                                base: \".\",\r\n                        width: \"100%\",\r\n                        height: \"100%\",\r\n                        hlshtml: true,\r\n                        autostart: true,\r\n                        fullscreen: true,\r\n                        playbackRateControls: true,\r\n                        displayPlaybackLabel: true,\r\n                        aspectratio: \"16:9\",\r\n                                                sharing: {\r\n                            sites: [\"reddit\",\"facebook\",\"twitter\",\"googleplus\",\"email\",\"linkedin\"]\r\n                        },\r\n                                                advertising: {\r\n\t        client: \'vast\',\r\n\t        admessage: \'Qu\u1ea3ng c\u00e1o c\u00f2n XX gi\u00e2y.\',\r\n\t        skiptext: \'B\u1ecf qua qu\u1ea3ng c\u00e1o\',\r\n\t        skipmessage: \'B\u1ecf qua sau xxs\',\r\n\t        schedule: {\r\n\t            \'qc1\': {\r\n\t                \'offset\': \'1\',\r\n\t                \'skipoffset\': \'5\',\r\n\t                \'tag\': \'http:\/\/xemphimplus.net\/link\/ads.xml\'\r\n\t            },\r\n\t        }\r\n\t    }                    });\r\n                    halimResumeVideo(resumeId, playerInstance);\r\n                    halimJwConfig(playerInstance);\r\n                                    }\r\n            <\/script>\r\n        <div class=\"embed-responsive embed-responsive-16by9\"><iframe class=\"embed-responsive-item\" src=\"https:\/\/drive.google.com\/file\/d\/1Itae9uwt7G7tRgFFCq0IhMTwib8j4ijg\/preview\" allowfullscreen><\/iframe><\/div>"}}';
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
