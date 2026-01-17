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
use Juzaweb\Modules\VideoSharing\Models\Playlist;

class PlaylistController extends ThemeController
{
    public function json()
    {
        $playlists = Playlist::select('id', 'name')->get();

        return response()->json(['data' => $playlists]);
    }
}
