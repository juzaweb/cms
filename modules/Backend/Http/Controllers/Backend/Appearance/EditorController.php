<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Backend\Http\Controllers\Backend\Appearance;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Juzaweb\Backend\Http\Requests\Theme\EditorRequest;
use Juzaweb\CMS\Contracts\LocalThemeRepositoryContract;
use Juzaweb\CMS\Facades\ThemeLoader;
use Juzaweb\CMS\Http\Controllers\BackendController;
use TwigBridge\Facade\Twig;

class EditorController extends BackendController
{
    protected array $editSupportExtensions = ['twig', 'blade.php', 'tsx'];

    public function __construct(protected LocalThemeRepositoryContract $themeRepository)
    {
    }

    public function index(Request $request, string $theme = null): View
    {
        $title = trans('cms::app.theme_editor');
        $theme = $theme ?: jw_current_theme();
        $themePath = $this->themeRepository->find($theme)?->getPath();
        $themes = $this->themeRepository->all();
        $directories = $this->getThemeTree("{$themePath}/views", convert_linux_path($themePath));

        $file = $this->getCurrentFile($request, $themePath);
        //$path = Crypt::decryptString($file);

        /*if (!file_exists("{$themePath}/{$path}")) {
            abort(404, "Cannot find file {$path}");
        }*/

        return view(
            'cms::backend.appearance.editor.index',
            compact(
                'title',
                'directories',
                'file',
                'theme',
                'themes'
            )
        );
    }

    public function getFileContent(Request $request, string $theme): JsonResponse
    {
        $this->validate(
            $request,
            [
                'file' => 'required',
            ]
        );

        $file = Crypt::decryptString($request->get('file'));
        $file = str_replace('..', '', $file);
        $repository = $this->themeRepository->find($theme);

        throw_if($repository === null, new \RuntimeException('Theme not found'));

        if (!$repository->fileExists($file)) {
            return abort(404);
        }

        return response()->json(
            [
                'content' => $repository->getContents($file),
                'language' => $this->getLanguageFile($file),
            ]
        );
    }

    public function save(EditorRequest $request, string $theme): JsonResponse|RedirectResponse
    {
        $file = Crypt::decryptString($request->input('file'));
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        $contents = $request->input('content');
        $repository = $this->themeRepository->find($theme);

        throw_if($repository === null, new \RuntimeException('Theme not found'));

        if (!in_array($extension, $this->editSupportExtensions)) {
            return $this->error("Unable to edit file {$extension}");
        }

        /* Test render theme */
        try {
            ThemeLoader::set($theme);
            $temp = Twig::createTemplate($contents, 'test');
            $temp->render();
        } catch (\Exception $e) {
            report($e);
            return $this->error(
                [
                    'message' => $e->getMessage(),
                ]
            );
        }

        $filePath = str_replace('views/', '', $file);
        if (!is_dir(dirname($repository->getViewPublicPath($filePath)))) {
            File::makeDirectory(
                dirname($repository->getViewPublicPath($filePath)),
                0775,
                true
            );
        }

        File::put($repository->getViewPublicPath($filePath), $contents);

        return $this->success(
            [
                'message' => trans('cms::app.save_successfully'),
            ]
        );
    }

    protected function getViewName($file): ?string
    {
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        if ($extension != 'twig') {
            return null;
        }

        $view = str_replace(array('views/', '.twig', '/'), array('', '', '.'), $file);

        return 'theme::'.$view;
    }

    protected function getThemeTree($folder, $sourcePath): array
    {
        $result = [];
        $directories = File::directories($folder);
        foreach ($directories as $directory) {
            $result[] = [
                'type' => 'dir',
                'name' => basename($directory),
                'children' => $this->getThemeTree($directory, $sourcePath),
            ];
        }

        $files = File::files($folder);
        foreach ($files as $file) {
            $path = str_replace(
                $sourcePath.'/',
                '',
                convert_linux_path($file->getRealPath())
            );

            $result[] = [
                'type' => 'file',
                'name' => $file->getFilename(),
                'path' => Crypt::encryptString($path),
            ];
        }

        return $result;
    }

    protected function getLanguageFile(string $file): string
    {
        $extension = pathinfo($file, PATHINFO_EXTENSION);

        return match ($extension) {
            'js' => 'javascript',
            default => $extension,
        };
    }

    protected function getCurrentFile(Request $request, string $themePath): string
    {
        return $request->get(
            'file',
            Crypt::encryptString($this->findIndexFile($themePath))
        );
    }

    protected function findIndexFile(string $themePath): ?string
    {
        // Twig theme
        if (File::exists("{$themePath}/views/index.twig")) {
            return 'views/index.twig';
        }

        // Blade theme
        if (File::exists("{$themePath}/views/index.blade.php")) {
            return 'views/index.blade.php';
        }

        // Inertia theme
        return 'views/index.tsx';
    }
}
