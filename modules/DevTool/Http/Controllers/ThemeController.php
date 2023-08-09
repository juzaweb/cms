<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\DevTool\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Inertia\Response;
use Juzaweb\CMS\Contracts\LocalThemeRepositoryContract;
use Juzaweb\CMS\Http\Controllers\BackendController;

class ThemeController extends BackendController
{
    protected string $template = 'inertia';

    public function __construct(
        protected LocalThemeRepositoryContract $themeRepository
    ) {
        //
    }

    public function index(Request $request, string $name): View|Response
    {
        $theme = $this->themeRepository->findOrFail($name);

        $title = "Dev tool for theme: {$theme->getName()}";

        $configs = $this->getThemeConfigs();

        return $this->view(
            'cms::backend.dev-tool.theme.index',
            compact('theme', 'title', 'configs')
        );
    }

    public function makePostType(Request $request, string $name): View|Response
    {
        $theme = $this->themeRepository->findOrFail($name);

        $title = "Dev tool for theme: {$theme->getName()}";

        $configs = $this->getThemeConfigs();

        return $this->view(
            'cms::backend.dev-tool.theme.post-type',
            compact('theme', 'title', 'configs')
        );
    }

    protected function getThemeConfigs(): array
    {
        return [];
    }
}
