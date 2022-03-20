<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Movie\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Juzaweb\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Juzaweb\Backend\Http\Resources\PostResource;
use Juzaweb\Backend\Http\Resources\ResourceResource;
use Juzaweb\Backend\Http\Resources\TaxonomyResource;
use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Models\Resource;
use Juzaweb\Backend\Models\Taxonomy;
use Juzaweb\Movie\Helpers\VideoFile;
use TwigBridge\Facade\Twig;

class AjaxController extends Controller
{
    public function getFilterForm(Request $request)
    {
        $genres = Taxonomy::where(
            'taxonomy',
            '=',
            'genres'
        )
            ->get();
        $countries = Taxonomy::where('taxonomy', '=', 'countries')
            ->get();
        $years = Taxonomy::where('taxonomy', '=', 'years')
            ->get();

        return Twig::render('theme::components.filter_form', [
            'genres' => TaxonomyResource::collection($genres)->toArray($request),
            'countries' => TaxonomyResource::collection($countries)->toArray($request),
            'years' => TaxonomyResource::collection($years)->toArray($request),
        ]);
    }

    public function getMoviesByGenre(Request $request)
    {
        $genre = $request->get('cat_id');
        $showpost = $request->get('showpost', 12);

        if ($showpost > 20) {
            $showpost = 12;
        }

        $query = Post::selectFrontendBuilder();
        $query->whereTaxonomy($genre);
        $query->limit($showpost);

        $posts = PostResource::collection($query->get())
            ->toArray($request);

        return Twig::render(
            'theme::components.movies_by_genre',
            [
                'items' => $posts
            ]
        );
    }

    public function getPopularMovies(Request $request)
    {
        $type = $request->get('type');
        $items = $this->getPopular($type);

        foreach ($items as $item) {
            $item->url = $item->getLink();
            $item->thumbnail = $item->getThumbnail();
            $item->views = $item->views .' '. trans('cms::app.views');
            $item->origin_title = (string) $item->getMeta('origin_title');
            $item->year = $item->getMeta('year');
        }

        return response()->json([
            'items' => $items
        ]);
    }

    public function getPlayer(Request $request)
    {
        $slug = $request->post('slug');
        $vid = $request->post('vid');

        $movie = Post::createFrontendBuilder()
            ->where('slug', '=', $slug)
            ->firstOrFail();

        if (get_config('only_member_view') == 1) {
            if (!Auth::check()) {
                $file = new VideoFile();
                $file->source = 'embed';
                $files[] = (object) ['file' => route('watch.no-view')];

                return response()->json([
                    'data' => [
                        'status' => true,
                        'sources' => Twig::render(
                            'theme::components.player_script',
                            [
                                'movie' => $movie,
                                'file' => $file,
                                'files' => $files,
                            ]
                        ),
                    ]
                ]);
            }
        }

        $video = Resource::find($vid);

        if ($video) {
            $files = (new VideoFile())->getFiles($video);
            $ads_exists = false;// VideoAds::where('status', 1)->exists();
            $video = (new ResourceResource($video))->toArray($request);

            return response()->json([
                'data' => [
                    'status' => true,
                    'sources' => Twig::render(
                        'theme::components.player_script',
                        compact(
                            'video',
                            'files',
                            'ads_exists',
                            'movie'
                        )
                    ),
                ]
            ]);
        }

        return response()->json([
            'data' => [
                'status' => false,
            ]
        ]);
    }

    public function download(Request $request)
    {
        $link = $request->input('link');
        $download = DownloadLink::find($link);
        if (empty($download) || $download->status != 1) {
            return abort(404);
        }

        return redirect()->to($download->url);
    }

    public function ads()
    {
        $video_ads = VideoAds::where('status', '=', 1)
            ->inRandomOrder()
            ->first();

        if (empty($video_ads)) {
            $factory = new \Sokil\Vast\Factory();
            $document = $factory->create('2.0');
            $document->toDomDocument();
            return $document;
        }

        return $this->getAds($video_ads);
    }

    protected function getAds(VideoAds $video_ads)
    {
        $factory = new \Sokil\Vast\Factory();
        $document = $factory->create('2.0');

        $ad1 = $document
            ->createInLineAdSection()
            ->setId('ad1')
            ->setAdSystem($video_ads->name)
            ->setAdTitle($video_ads->title)
            ->addImpression('http://ad.server.com/impression', 'imp1');

        $linearCreative = $ad1
            ->createLinearCreative()
            ->setDuration(1)
            ->setId('013d876d-14fc-49a2-aefd-744fce68365b')
            ->setAdId('pre')
            ->setVideoClicksClickThrough('http://entertainmentserver.com/landing')
            ->addVideoClicksClickTracking('http://ad.server.com/videoclicks/clicktracking')
            ->addVideoClicksCustomClick('http://ad.server.com/videoclicks/customclick')
            ->addTrackingEvent('start', 'http://ad.server.com/trackingevent/start')
            ->addTrackingEvent('pause', 'http://ad.server.com/trackingevent/stop');

        $linearCreative
            ->createClosedCaptionFile()
            ->setLanguage('en-US')
            ->setType('text/srt')
            ->setUrl('http://server.com/cc.srt');

        $linearCreative
            ->createMediaFile()
            ->setProgressiveDelivery()
            ->setType('video/mp4')
            ->setHeight(100)
            ->setWidth(100)
            ->setBitrate(2500)
            ->setUrl(upload_url($video_ads->getVideoUrl()));

        $document->toDomDocument();
        return $document;
    }

    protected function getPopular($type)
    {
        $query = Post::selectFrontendBuilder();
        $query->where('type', '=', 'movies');

        if ($type == 'day' || $type == 'month') {
            switch ($type) {
                case 'day':
                    $date = date('Y-m-d');
                    break;
                case 'month':
                    $date = date('Y-m');
                    break;
                default:
                    $date = date('Y-m-d');
                    break;
            }

            $query->whereHas(
                'postViews',
                function (Builder $q) use ($date) {
                    $q->where('day', 'like', $date . '%');
                    $q->orderBy('views', 'desc');
                }
            );
        }

        if ($type == 'week') {
            $day = date('w');
            $week_start = date('Y-m-d', strtotime('-'. $day .' days'));
            $week_end = date('Y-m-d', strtotime('+'. (6-$day) .' days'));

            $query->whereHas(
                'postViews',
                function (Builder $q) use ($week_start, $week_end) {
                    $q->where('day', '>=', $week_start);
                    $q->where('day', '<=', $week_end);
                    $q->orderBy('views', 'desc');
                }
            );
        }

        $query->orderBy('views', 'DESC');
        $query->limit(10);

        return $query->get();
    }
}
