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
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Inertia\Response;
use Juzaweb\CMS\Contracts\LocalPluginRepositoryContract;
use Juzaweb\DevTool\Http\Controllers\Controller;
use Symfony\Component\Console\Output\BufferedOutput;

class CRUDController extends Controller
{
    public function __construct(
        protected LocalPluginRepositoryContract $pluginRepository
    ) {
        //
    }

    public function index(Request $request, string $vendor, string $name): View|Response
    {
        $plugin = $this->pluginRepository->findOrFail("{$vendor}/{$name}");
        $title = "Make CRUD for plugin: {$plugin->getName()}";

        $configs = $this->getConfigs('plugins');

        return $this->view(
            'cms::backend.dev-tool.plugin.crud.index',
            compact('plugin', 'title', 'configs')
        );
    }

    public function store(Request $request, string $vendor, string $name): JsonResponse|RedirectResponse
    {
        $plugin = $this->pluginRepository->findOrFail("{$vendor}/{$name}");
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

        // if ($request->input('make_menu', 0)) {
        //     $register = $this->getPluginRegister($plugin);
        //     $label = $request->input('label', Str::ucfirst(Str::replace('_', ' ', $table)));
        //
        //     $register['admin_pages'] = [
        //         'title' => $label,
        //         'menu' => [
        //             'icon' => 'fa fa-list',
        //             'position' => $request->input('menu_position', 30),
        //         ],
        //     ];
        //
        //     $this->writeRegisterFile($plugin, $register);
        // }

        return $this->success(
            [
                'message' => 'CRUD created successfully.',
                'output' => $outputBuffer->fetch(),
            ]
        );
    }
}
