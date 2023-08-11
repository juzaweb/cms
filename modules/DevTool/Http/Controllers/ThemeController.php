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

class ThemeController extends Controller
{
    public function __construct(
        protected LocalThemeRepositoryContract $themeRepository
    ) {
        //
    }

    public function index(Request $request): View|Response
    {
        $title = "Dev tool for themes";

        $configs = $this->getConfigs('themes');

        return $this->view(
            'cms::backend.dev-tool.theme.index',
            compact('title', 'configs')
        );
    }

    public function edit(Request $request, string $name): View|Response
    {
        die;
        $theme = $this->themeRepository->findOrFail($name);

        $title = "Dev tool for theme: {$theme->getName()}";

        $configs = $this->getConfigs('themes');

        return $this->view(
            'cms::backend.dev-tool.theme.edit',
            compact('theme', 'title', 'configs')
        );
    }

    public function create()
    {
        $title = "Make new themes";
        $configs = $this->getConfigs('themes');

        return $this->view(
            'cms::backend.dev-tool.theme.create',
            compact('configs', 'title')
        );
    }
}
