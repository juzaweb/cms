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
use Juzaweb\Modules\Admin\Models\Guest;
use Juzaweb\Modules\Core\Http\Controllers\ThemeController;
use Juzaweb\Modules\Core\Models\Pages\Page;
use Juzaweb\Modules\VideoSharing\Models\Video;

class PageController extends ThemeController
{
    public function show(string $slug)
    {
        $page = Page::whereFrontend(['page_translations', 'page_translations:' . $slug])
            ->cacheTags(['pages', "pages:{$slug}"])
            ->whereTranslation('slug', $slug)
            ->firstOrFail();

        return view(
            page_view_name($page, 'itube'),
            [
                ...compact('page'),
                'title' => $page->title,
                'description' => $page->description,
                'ogType' => 'article',
                'image' => $page->thumbnail,
            ]
        );
    }

    public function trending()
    {
        $videos = Video::whereFrontend()
            ->orderBy('views', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view(
            'itube::trending',
            [
                ...compact('videos'),
                'title' => __('itube::translation.trending'),
                'description' => __('itube::translation.trending_videos'),
                'ogType' => 'article',
            ]
        );
    }

    public function history(Request $request)
    {
        $user = $this->getUserWithGuest($request);
        $videos = Video::whereFrontend()
            ->join('page_view_histories', function ($join) use ($user) {
                $join->on('videos.id', '=', 'page_view_histories.viewable_id')
                    ->where('page_view_histories.viewable_type', Video::class)
                    ->where('page_view_histories.viewer_id', $user->id)
                    ->where('page_view_histories.viewer_type', get_class($user));
            })
            ->select(['videos.*'])
            ->orderBy('page_view_histories.created_at', 'desc')
            ->paginate(12);

        return view(
            'itube::history',
            [
                ...compact('videos'),
                'title' => __('itube::translation.history'),
                'description' => __('itube::translation.history_videos'),
                'ogType' => 'article',
            ]
        );
    }

    protected function getUserWithGuest(Request $request)
    {
        if ($request->user()) {
            return $request->user();
        }

        return Guest::firstOrCreate(
            [
                'ipv4' => client_ip(),
            ],
            [
                'user_agent' => $request->userAgent(),
            ]
        );
    }
}
