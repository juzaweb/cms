<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\DevTool\Http\Controllers\Themes;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Inertia\Response;
use Juzaweb\CMS\Contracts\HookActionContract;
use Juzaweb\CMS\Contracts\LocalThemeRepositoryContract;
use Juzaweb\DevTool\Http\Controllers\Controller;
use Juzaweb\DevTool\Http\Requests\PostTypeRequest;

class TaxonomyController extends Controller
{
    public function __construct(
        protected LocalThemeRepositoryContract $themeRepository,
        protected HookActionContract $hookAction
    ) {
        //
    }

    public function create(Request $request, string $name): View|Response
    {
        $theme = $this->themeRepository->findOrFail($name);
        $title = "Dev tool for theme: {$theme->getName()}";

        $configs = $this->getConfigs('themes');
        $postTypes = $this->hookAction->getPostTypes()->values();

        return $this->view(
            'cms::backend.dev-tool.theme.taxonomy.create',
            compact('theme', 'title', 'configs', 'postTypes')
        );
    }

    public function store(PostTypeRequest $request, string $name): JsonResponse|RedirectResponse
    {
        $theme = $this->themeRepository->findOrFail($name);
        $key = Str::plural(Str::slug($request->input('key')));

        if ($this->hookAction->getTaxonomies($key)->isNotEmpty()) {
            return $this->error("Taxonomy {$key} already exists.");
        }

        $register = $this->getThemeRegister($theme);

        $register['taxonomies'][$key] = array_merge(
            $register['taxonomies'][$key] ?? [],
            $request->except(['key'])
        );

        File::put($theme->getPath('register.json'), json_encode($register, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT));

        return $this->success(['message' => 'Post type created successfully.']);
    }
}
