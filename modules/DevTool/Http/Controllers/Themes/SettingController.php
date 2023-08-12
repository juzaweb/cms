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
use Illuminate\Http\Request;
use Inertia\Response;
use Juzaweb\CMS\Contracts\LocalThemeRepositoryContract;
use Juzaweb\CMS\Interfaces\Theme\ThemeInterface;
use Juzaweb\DevTool\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function __construct(protected LocalThemeRepositoryContract $themeRepository)
    {
        //
    }

    public function index(string $themeName): View|Response
    {
        $title = __('Theme Setting Fields');
        $configs = $this->getConfigs('themes');
        $theme = $this->themeRepository->findOrFail($themeName);
        $settings = $this->getSettingFields($theme);

        return $this->view(
            'cms::backend.dev-tool.theme.config.index',
            compact('settings', 'configs', 'title', 'theme')
        );
    }

    public function update(Request $request, string $themeName)
    {
        $theme = $this->themeRepository->findOrFail($themeName);


    }

    protected function getSettingFields(ThemeInterface $theme): array
    {
        return collect($theme->getRegister('setting_fields'))
            ->map(
                function ($item, $key) {
                    $item['key'] = $key;
                    return $item;
                }
            )
            ->values()
            ->toArray();
    }
}
