<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Backend\Http\Controllers\Backend\Plugin;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Juzaweb\Backend\Http\Requests\Theme\EditorRequest;
use Juzaweb\CMS\Contracts\LocalPluginRepositoryContract;
use Juzaweb\CMS\Http\Controllers\BackendController;

class EditorController extends BackendController
{
    protected array $editSupportExtensions = ['twig', 'php', 'js', 'css', 'json'];

    public function __construct(protected LocalPluginRepositoryContract $pluginRepository)
    {
    }

    public function index(Request $request): View
    {
        $title = trans('cms::app.plugin_editor');
        $plugin = $request->query('plugin', 'juzaweb/example');
        $repository = $this->pluginRepository->find($plugin);
        $plugins = $this->pluginRepository->all();
        $pluginPath = convert_linux_path($repository->getPath());
        $directories = $this->getTree($pluginPath, $pluginPath);

        $file = $this->getCurrentFile($request);
        $path = Crypt::decryptString($file);
        if (!file_exists("{$pluginPath}/{$path}")) {
            return abort(404);
        }

        return view(
            'cms::backend.plugin.editor.index',
            compact(
                'title',
                'directories',
                'file',
                'plugin',
                'plugins'
            )
        );
    }

    public function getFileContent(Request $request): JsonResponse
    {
        $this->validate(
            $request,
            [
                'file' => 'required',
                'plugin' => 'required'
            ]
        );

        $plugin = $request->query('plugin', 'juzaweb/example');
        $file = Crypt::decryptString($request->get('file'));
        $file = str_replace('..', '', $file);
        $repository = $this->pluginRepository->find($plugin);

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

    public function save(EditorRequest $request): JsonResponse|RedirectResponse
    {
        $plugin = $request->input('plugin', 'juzaweb/example');
        $file = Crypt::decryptString($request->input('file'));
        $contents = $request->input('content');
        $repository = $this->pluginRepository->find($plugin);
        $extension = pathinfo($file, PATHINFO_EXTENSION);

        if (!in_array($extension, $this->editSupportExtensions)) {
            return $this->error("Unable to edit file {$extension}.");
        }

        if (!is_dir(dirname($repository->getPath($file)))) {
            File::makeDirectory(
                dirname($repository->getPath($file)),
                0775,
                true
            );
        }

        File::put($repository->getPath($file), $contents);

        return $this->success(
            [
                'message' => trans('cms::app.save_successfully'),
            ]
        );
    }

    protected function getTree($folder, $sourcePath): array
    {
        $result = [];
        $directories = File::directories($folder);
        foreach ($directories as $directory) {
            $result[] = [
                'type' => 'dir',
                'name' => basename($directory),
                'children' => $this->getTree($directory, $sourcePath),
            ];
        }

        $files = File::files($folder);
        foreach ($files as $file) {
            $path = str_replace(
                convert_linux_path(realpath($sourcePath)) . '/',
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

    protected function getCurrentFile(Request $request): string
    {
        return $request->get(
            'file',
            Crypt::encryptString('composer.json')
        );
    }
}
