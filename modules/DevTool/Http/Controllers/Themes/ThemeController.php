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
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Inertia\Response;
use Juzaweb\CMS\Contracts\LocalThemeRepositoryContract;
use Juzaweb\DevTool\Http\Controllers\Controller;
use Juzaweb\DevTool\Http\Requests\Theme\StoreRequest;
use Symfony\Component\Console\Output\BufferedOutput;

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
        $theme = $this->themeRepository->findOrFail($name);

        $title = "Dev tool for theme: {$theme->getName()}";

        $configs = $this->getConfigs('themes');

        return $this->view(
            'cms::backend.dev-tool.theme.edit',
            compact('theme', 'title', 'configs')
        );
    }

    public function create(): View|Response
    {
        $title = "Make new themes";

        return $this->view(
            'cms::backend.dev-tool.theme.create',
            compact('title')
        );
    }

    public function store(StoreRequest $request): JsonResponse|RedirectResponse
    {
        $name = Str::slug($request->input('name'));
        if ($this->themeRepository->has($name)) {
            return $this->error("Theme {$name} already exists!");
        }

        $outputBuffer = new BufferedOutput();

        try {
            Artisan::call(
                'theme:make',
                [
                    'name' => $name,
                    '--title' => $request->input('title'),
                    '--description' => $request->input('description'),
                    '--author' => $request->input('author'),
                    '--ver' => $request->input('version'),
                ],
                $outputBuffer
            );
        } catch (\Throwable $e) {
            return $this->error($e->getMessage());
        }

        return $this->success(
            [
                'message' => "Theme {$name} created successfully!",
                'output' => $outputBuffer->fetch(),
            ]
        );
    }
}
