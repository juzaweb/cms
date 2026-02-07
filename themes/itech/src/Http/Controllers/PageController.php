<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://cms.juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\Themes\Itech\Http\Controllers;

use Juzaweb\Modules\Core\Http\Controllers\ThemeController;
use Juzaweb\Modules\Core\Models\Pages\Page;

class PageController extends ThemeController
{
    public function show(string $slug)
    {
        $page = Page::whereFrontend(['page_translations', 'page_translations:' . $slug])
            ->cacheTags(['pages', "pages:{$slug}"])
            ->whereTranslation('slug', $slug)
            ->firstOrFail();

        return view(
            page_view_name($page, 'itech'),
            [
                ...compact('page'),
                'title' => $page->title,
                'description' => $page->description,
                'ogType' => 'article',
                'image' => $page->thumbnail,
            ]
        );
    }
}
