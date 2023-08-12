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
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
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

    public function update(Request $request, string $themeName): JsonResponse|RedirectResponse
    {
        $theme = $this->themeRepository->findOrFail($themeName);

        $register = $this->getThemeRegister($theme);

        $settings = $this->collectInputData($request->input('settings', []));

        // Merge current data
        foreach ($settings as $key => $item) {
            $register['templates'][$key] = array_merge($register['templates'][$key] ?? [], $item);
        }

        // Delete unused
        foreach ($register['templates'] as $key => $item) {
            if (!isset($settings[$key])) {
                unset($register['templates'][$key]);
            }
        }

        File::put(
            $theme->getPath('register.json'),
            json_encode($register, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT)
        );

        return $this->success('Theme Settings updated.');
    }

    protected function collectInputData(array $settings): array
    {
        return collect($settings)
            ->mapWithKeys(
                function ($item) {
                    $name = Str::slug($item['name'], '_');
                    unset($item['name']);

                    if (isset($item['blocks'])) {
                        $item['blocks'] = collect($item['blocks'])->mapWithKeys(
                            function ($item) {
                                $key = Str::slug($item['name'], '_');
                                unset($item['name']);
                                return [$key => $item];
                            }
                        )->toArray();
                    }

                    return [$name => $item];
                }
            )
            ->filter(fn ($item, $key) => !empty($key))
            ->toArray();
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
