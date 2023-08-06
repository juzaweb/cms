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
use Inertia\Response;
use Juzaweb\CMS\Contracts\LocalPluginRepositoryContract;
use Juzaweb\CMS\Contracts\LocalThemeRepositoryContract;
use Juzaweb\CMS\Http\Controllers\BackendController;

class DevToolController extends BackendController
{
    protected string $template = 'inertia';

    public function __construct(
        protected LocalPluginRepositoryContract $pluginRepository,
        protected LocalThemeRepositoryContract $themeRepository
    ) {
        //
    }

    public function index(): View|Response
    {
        $title = __('Dev Tool');
        $themes = $this->themeRepository->all(true)->values();
        $plugins = $this->pluginRepository->all(true)->values();

        return $this->view(
            'dev-tool/index',
            compact('title', 'themes', 'plugins')
        );
    }
}
