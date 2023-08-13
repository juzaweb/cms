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
use Illuminate\Support\Str;
use Inertia\Response;
use Juzaweb\CMS\Contracts\HookActionContract;
use Juzaweb\CMS\Contracts\LocalPluginRepositoryContract;
use Juzaweb\DevTool\Http\Controllers\Controller;
use Juzaweb\DevTool\Http\Requests\TaxonomyRequest;

class TaxonomyController extends Controller
{
    public function __construct(
        protected LocalPluginRepositoryContract $pluginRepository,
        protected HookActionContract $hookAction
    ) {
        //
    }

    public function index(Request $request, string $vendor, string $name): View|Response
    {
        $plugin = $this->pluginRepository->findOrFail("{$vendor}/{$name}");
        $title = "Dev tool for plugin: {$plugin->getName()}";

        $configs = $this->getConfigs('plugins');
        $postTypes = $this->hookAction->getPostTypes()->values();

        return $this->view(
            'cms::backend.dev-tool.plugin.taxonomy.index',
            compact('plugin', 'title', 'configs', 'postTypes')
        );
    }

    public function store(TaxonomyRequest $request, string $vendor, string $name): JsonResponse|RedirectResponse
    {
        $plugin = $this->pluginRepository->findOrFail("{$vendor}/{$name}");
        $key = Str::plural(Str::slug($request->input('key')));

        if ($this->hookAction->getTaxonomies($key)->isNotEmpty()) {
            return $this->error("Taxonomy {$key} already exists.");
        }

        $register = $this->getPluginRegister($plugin);
        $register['taxonomies'][$key] = array_merge(
            $register['taxonomies'][$key] ?? [],
            $request->except(['key'])
        );

        $this->writeRegisterFile($plugin, $register);

        return $this->success(['message' => 'Taxonomy created successfully.']);
    }
}
