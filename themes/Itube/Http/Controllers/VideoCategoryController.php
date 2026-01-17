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

use Juzaweb\Modules\Core\Http\Controllers\ThemeController;
use Juzaweb\Modules\VideoSharing\Models\Video;
use Juzaweb\Modules\VideoSharing\Models\VideoCategory;

class VideoCategoryController extends ThemeController
{
    public function show(string $slug)
    {
        $videoCategory = VideoCategory::whereTranslation('slug', $slug)
            ->whereInFrontend()
            ->firstOrFail();
        $videos = Video::whereFrontend()
            ->whereHas('categories', function ($query) use ($videoCategory) {
                $query->where('video_categories.id', $videoCategory->id);
            })
            ->paginate(12);

        return view(
            'itube::video-category.show',
            [
                ...compact('videoCategory', 'videos'),
                'title' => $videoCategory->name,
                'image' => $videoCategory->thumbnail,
                'ogType' => 'object',
            ]
        );
    }
}
