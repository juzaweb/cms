<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\DevTool\Http\Controllers\PostTypes;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Inertia\Response;
use Juzaweb\CMS\Contracts\LocalThemeRepositoryContract;
use Juzaweb\CMS\Http\Controllers\BackendController;

class ThemePostTypeController extends BackendController
{
    protected string $template = 'inertia';

    public function __construct(
        protected LocalThemeRepositoryContract $themeRepository
    ) {
        //
    }

    public function create(Request $request, string $name): View|Response
    {
        $theme = $this->themeRepository->findOrFail($name);

        $title = "Dev tool for theme: {$theme->getName()}";

        $configs = $this->getThemeConfigs();

        return $this->view(
            'cms::backend.dev-tool.theme.post-type.create',
            compact('theme', 'title', 'configs')
        );
    }

    protected function getThemeConfigs(): array
    {
        $configs = config("dev-tool.themes", []);

        $convertToArray = function (array $item, string $key) {
            $item['key'] = $key;
            return $item;
        };

        $configs['options'] = collect($configs['options'])
            ->map($convertToArray)
            ->values();

        return $configs;
    }
}
