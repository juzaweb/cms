<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\DevTool\Http\Controllers\Themes;

use Illuminate\Contracts\View\View;
use Inertia\Response;
use Juzaweb\CMS\Contracts\LocalThemeRepositoryContract;
use Juzaweb\CMS\Interfaces\Theme\ThemeInterface;
use Juzaweb\DevTool\Http\Controllers\Controller;

class TemplateController extends Controller
{
    public function __construct(protected LocalThemeRepositoryContract $themeRepository)
    {
        //
    }

    public function index(string $themeName): View|Response
    {
        $title = __('Theme Templates');
        $configs = $this->getConfigs('themes');

        $theme = $this->themeRepository->findOrFail($themeName);
        $settings = $this->getSettingFields($theme);

        return $this->view(
            'cms::backend.dev-tool.theme.template.index',
            compact('settings', 'configs', 'title', 'theme')
        );
    }

    protected function getSettingFields(ThemeInterface $theme): array
    {
        $collection = collect($theme->getRegister('templates'))
            ->map(
                function ($item, $key) {
                    if (!is_numeric($key)) {
                        $item['name'] = $key;
                    }

                    if (isset($item['blocks'])) {
                        $item['blocks'] = collect($item['blocks'])->map(
                            function ($item, $key) {
                                if (!is_numeric($key)) {
                                    $item['name'] = $key;
                                }
                                return $item;
                            }
                        )->values()->toArray();
                    }

                    return $item;
                }
            );

        return $collection
            ->values()
            ->toArray();
    }
}
