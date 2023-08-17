<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\DevTool\Http\Controllers\Plugins;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Inertia\Response;
use Juzaweb\CMS\Contracts\LocalPluginRepositoryContract;
use Juzaweb\CMS\Support\Plugin;
use Juzaweb\DevTool\Http\Controllers\Controller;

class PluginController extends Controller
{
    public function __construct(
        protected LocalPluginRepositoryContract $pluginRepository
    ) {
        //
    }

    public function index(Request $request, string $vendor, string $name): View|Response
    {
        $plugin = $this->findPlugin($vendor, $name);

        $title = "Dev tool for plugin: {$plugin->getName()}";

        $configs = $this->getPluginConfigs();

        return $this->view(
            'cms::backend.dev-tool.plugin.index',
            compact('plugin', 'title', 'configs')
        );
    }

    protected function findPlugin(string $vendor, string $name): Plugin
    {
        $plugin = $this->pluginRepository->find("{$vendor}/{$name}");

        throw_if($plugin === null, new \Exception('Plugin not found'));

        return $plugin;
    }
}
