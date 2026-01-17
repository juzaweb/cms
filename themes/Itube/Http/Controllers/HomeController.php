<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://cms.juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\Themes\Itube\Http\Controllers;

use Illuminate\Http\Request;
use Juzaweb\Modules\Core\Http\Controllers\ThemeController;
use Juzaweb\Modules\VideoSharing\Models\Video;

class HomeController extends ThemeController
{
    public function index()
    {
        $trendingVideos = Video::with(['media', 'channel'])
            ->withTranslation()
            ->whereFrontend()
            ->orderBy('views', 'desc')
            ->take(10)
            ->get();

        $videos = Video::with(['media', 'channel'])
            ->withTranslation()
            ->whereFrontend()
            ->whereNotIn('id', $trendingVideos->pluck('id'))
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view(
            'itube::index',
            compact('trendingVideos', 'videos')
        );
    }

    public function loadMoreVideos(Request $request)
    {
        $page = $request->get('page', 1);
        $excludeIds = $request->get('excludeIds', '');
        
        $excludeIdsArray = !empty($excludeIds) ? explode(',', $excludeIds) : [];

        $videos = Video::with(['media', 'channel'])
            ->withTranslation()
            ->whereFrontend()
            ->when(!empty($excludeIdsArray), function ($query) use ($excludeIdsArray) {
                return $query->whereNotIn('id', $excludeIdsArray);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20, ['*'], 'page', $page);

        $html = $videos->map(function ($video) {
            return view('itube::components.video-item', ['video' => $video])->render();
        })->implode('');

        return response()->json([
            'success' => true,
            'html' => $html,
            'hasMore' => $videos->hasMorePages(),
            'nextPage' => $videos->currentPage() + 1
        ]);
    }
}
