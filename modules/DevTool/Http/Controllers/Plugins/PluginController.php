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
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Inertia\Response;
use Juzaweb\CMS\Contracts\LocalPluginRepositoryContract;
use Juzaweb\DevTool\Http\Controllers\Controller;
use Symfony\Component\Console\Output\BufferedOutput;

class PluginController extends Controller
{
    public function __construct(
        protected LocalPluginRepositoryContract $pluginRepository
    ) {
        //
    }

    public function edit(Request $request, string $vendor, string $name): View|Response
    {
        $plugin = $this->pluginRepository->findOrFail("{$vendor}/{$name}");

        $title = "Dev tool for plugin: {$plugin->getName()}";

        $configs = $this->getConfigs('plugins');

        return $this->view(
            'cms::backend.dev-tool.plugin.index',
            compact('plugin', 'title', 'configs')
        );
    }

    public function create(): View|Response
    {
        $title = "Make new a plugin";

        $configs = $this->getConfigs('plugins');

        return $this->view(
            'cms::backend.dev-tool.plugin.create',
            compact('title', 'configs')
        );
    }

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $name = $request->input('name');
        if ($this->pluginRepository->has($name)) {
            return $this->error("Plugin {$name} already exists!");
        }

        $outputBuffer = new BufferedOutput();

        try {
            Artisan::call(
                'plugin:make',
                [
                    'name' => [$name],
                    '--title' => $request->input('title'),
                    '--description' => $request->input('description'),
                    '--domain' => $request->input('domain'),
                    '--author' => $request->input('author'),
                    '--ver' => $request->input('version'),
                ],
                $outputBuffer
            );
        } catch (\Throwable $th) {
            report($th);
            return $this->error($th->getMessage());
        }

        return $this->success(
            [
                'message' => "Plugin {$name} created successfully!",
                'output' => $outputBuffer->fetch(),
            ]
        );
    }
}
