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
use Juzaweb\Modules\AdsManagement\Models\VideoAds;
use Juzaweb\Modules\Core\Http\Controllers\ThemeController;
use Juzaweb\Modules\VideoSharing\Models\Video;

class PlayController extends ThemeController
{
    public function player(Request $request, string $code)
    {
        $video = Video::with(['files'])
            ->where('code', $code)
            ->whereFrontend()
            ->firstOrFail();

        $hasAds = VideoAds::where(['position' => 'video-player', 'active' => 1])->exists();

        return $this->success(
            [
                'html' => view(
                    'itube::player',
                    compact('video', 'hasAds')
                )->render(),
            ],
        );
    }
}
