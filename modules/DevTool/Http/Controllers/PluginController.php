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
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Inertia\Response;
use Juzaweb\CMS\Contracts\LocalPluginRepositoryContract;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\CMS\Support\Plugin;
use Juzaweb\DevTool\Http\Requests\PostTypeRequest;
use Symfony\Component\Console\Output\BufferedOutput;

class PluginController extends BackendController
{
    protected string $template = 'inertia';

    public function __construct(
        protected LocalPluginRepositoryContract $pluginRepository
    ) {
        //
    }

    public function index(Request $request, string $vendor, string $name): View|Response
    {
        $plugin = $this->findPlugin($vendor, $name);

        $title = $plugin->getName();

        return $this->view(
            'cms::backend.dev-tool.plugin.index',
            compact('plugin', 'title')
        );
    }

    public function makePostType(PostTypeRequest $request, string $vendor, string $name): JsonResponse|RedirectResponse
    {
        $plugin = $this->findPlugin($vendor, $name);

        $key = Str::plural(Str::slug($request->input('key')));
        $register = $this->getPluginRegister($plugin);

        $register['post_types'][$key] = $request->all();

        File::put($plugin->getPath('register.json'), json_encode($register, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT));

        return $this->success(['message' => 'Post type created successfully.']);
    }

    public function makeTaxonomy(Request $request, string $vendor, string $name): JsonResponse|RedirectResponse
    {
        $plugin = $this->findPlugin($vendor, $name);

        $key = Str::plural(Str::slug($request->input('key')));
        $register = $this->getPluginRegister($plugin);

        $register['taxonomies'][$key] = $request->all();

        File::put($plugin->getPath('register.json'), json_encode($register, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT));

        return $this->success(['message' => 'Taxonomy created successfully.']);
    }

    public function makeCRUD(Request $request, string $vendor, string $name): JsonResponse|RedirectResponse
    {
        $plugin = $this->findPlugin($vendor, $name);
        $table = $request->input('table');

        if (!Schema::hasTable($table)) {
            return $this->error("Table [{$table}] does not exist. Please create table.");
        }

        $outputBuffer = new BufferedOutput;

        Artisan::call(
            'plugin:make-crud',
            ['module' => $plugin->getName(), 'name' => $request->input('table')],
            $outputBuffer
        );

        if ($request->input('make_menu', 0)) {
            $register = $this->getPluginRegister($plugin);
            $label = $request->input('label', Str::ucfirst(Str::replace('_', ' ', $table)));

            $register['admin_pages'] = [
                'title' => $label,
                'menu' => [
                    'icon' => 'fa fa-list',
                    'position' => $request->input('menu_position', 30),
                ],
            ];

            $this->writeRegisterFile($plugin, $register);
        }

        return $this->success(
            [
                'message' => 'CRUD created successfully.',
                'output' => $outputBuffer->fetch(),
            ]
        );
    }

    protected function writeRegisterFile(Plugin $plugin, array $register): bool
    {
        return File::put(
            $plugin->getPath('register.json'),
            json_encode($register, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT)
        );
    }

    protected function getPluginRegister(Plugin $plugin): array
    {
        $register = '[]';

        if (File::exists($plugin->getPath('register.json'))) {
            $register = File::get($plugin->getPath('register.json'));
        }

        return json_decode($register, true, 512, JSON_THROW_ON_ERROR);
    }

    protected function findPlugin(string $vendor, string $name): Plugin
    {
        $plugin = $this->pluginRepository->find("{$vendor}/{$name}");

        throw_if($plugin === null, new \Exception('Plugin not found'));

        return $plugin;
    }
}
