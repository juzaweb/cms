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
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Inertia\Response;
use Juzaweb\CMS\Contracts\LocalPluginRepositoryContract;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\DevTool\Http\Requests\PostTypeRequest;

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
        //
    }

    public function makePostType(PostTypeRequest $request, string $vendor, string $name): JsonResponse|RedirectResponse
    {
        $plugin = $this->pluginRepository->find("{$vendor}/{$name}");

        throw_if($plugin === null, new \Exception('Plugin not found'));

        $key = Str::plural(Str::slug($request->input('key')));
        $register = '[]';

        if (File::exists($plugin->getPath('register.json'))) {
            $register = File::get($plugin->getPath('register.json'));
        }

        $register = json_decode($register, true, 512, JSON_THROW_ON_ERROR);

        $register['post_types'][$key] = $request->all();

        File::put($plugin->getPath('register.json'), json_encode($register, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT));

        return $this->success(['message' => 'Post type created successfully.']);
    }
}
