<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Backend\Http\Controllers\Backend\Setting;

use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\CMS\Http\Controllers\BackendController;

class MediaController extends BackendController
{
    public function index(): \Illuminate\Contracts\View\View
    {
        $title = trans('Media Settings');
        $postTypes = HookAction::getPostTypes();
        $thumbnailDefaults = get_config('thumbnail_defaults', []);

        return view(
            'cms::backend.setting.media',
            compact(
                'title',
                'postTypes',
                'thumbnailDefaults'
            )
        );
    }
}
