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

class SearchController extends ThemeController
{
    public function index(Request $request)
    {
        $query = $request->get('q', '');
        
        $videos = Video::with(['media', 'channel'])
            ->withTranslation()
            ->whereFrontend()
            ->when($query, function ($q) use ($query) {
                return $q->whereHas('translations', function ($subQuery) use ($query) {
                    $subQuery->where('title', 'like', '%' . $query . '%')
                        ->orWhere('description', 'like', '%' . $query . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view(
            'itube::search',
            compact('videos', 'query')
        );
    }

    public function loadMore(Request $request)
    {
        $page = $request->get('page', 1);
        $query = $request->get('q', '');
        $trending = $request->get('trending', false);
        $category = $request->get('category');

        $videos = Video::with(['media', 'channel'])
            ->withTranslation()
            ->whereFrontend()
            ->when($query, function ($q) use ($query) {
                return $q->whereHas('translations', function ($subQuery) use ($query) {
                    $subQuery->where('title', 'like', '%' . $query . '%')
                        ->orWhere('description', 'like', '%' . $query . '%');
                });
            })
            ->when(
                $trending,
                function ($q) {
                    return $q->orderBy('views', 'desc');
                }
            )
            ->when(
                $category,
                function ($q) use ($category) {
                    return $q->whereHas('categories', function ($subQuery) use ($category) {
                        $subQuery->where('video_categories.id', $category);
                    });
                }
            )
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
