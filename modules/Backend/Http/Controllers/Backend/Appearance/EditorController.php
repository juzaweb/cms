<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Backend\Http\Controllers\Backend\Appearance;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Juzaweb\CMS\Facades\Theme;
use Juzaweb\CMS\Http\Controllers\BackendController;
use TwigBridge\Facade\Twig;

class EditorController extends BackendController
{
    protected array $supportExtensions = ['twig', 'js', 'css', 'json'];

    public function index(Request $request): View
    {
        $title = trans('cms::app.theme_editor');
        $themePath = Theme::find(jw_current_theme())->getPath();
        $directories = $this->getThemeTree(
            $themePath,
            convert_linux_path($themePath)
        );

        $file = $request->get(
            'file',
            Crypt::encryptString('views/index.twig')
        );

        $path = Crypt::decryptString($file);
        if (!file_exists($themePath.'/'.$path)) {
            return abort(404);
        }

        return view(
            'cms::backend.appearance.editor.index',
            compact(
                'title',
                'directories',
                'file'
            )
        );
    }

    public function getFileContent(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->validate(
            $request,
            [
                'file' => 'required',
            ]
        );

        $file = Crypt::decryptString($request->get('file'));
        $file = str_replace('..', '', $file);
        $themePath = Theme::getThemePath(jw_current_theme());

        $content = ThemeEditor::where('path', $file)->first(['content']);

        if (empty($content)) {
            if (!file_exists($themePath.'/'.$file)) {
                return abort(404);
            }

            $content = File::get($themePath.'/'.$file);
        } else {
            $content = $content->content;
        }

        return response()->json(
            [
                'content' => $content,
                'language' => pathinfo($file, PATHINFO_EXTENSION),
            ]
        );
    }

    public function save(Request $request)
    {
        $this->validate(
            $request,
            [
                'file' => 'required',
                'content' => 'required|string|max:10000',
            ]
        );

        $file = Crypt::decryptString($request->input('file'));
        $content = $request->input('content');

        if (!in_array(pathinfo($file, PATHINFO_EXTENSION), $this->supportExtensions)) {
            return abort(404);
        }

        try {
            $temp = Twig::createTemplate($content, 'test');
            $temp->render();
        } catch (\Exception $e) {
            Log::error($e);

            return $this->error(
                [
                    'message' => $e->getMessage(),
                ]
            );
        }

        $viewName = $this->getViewName($file);

        global $site;

        DB::beginTransaction();
        try {
            ThemeEditor::updateOrCreate(
                [
                    'theme' => jw_current_theme(),
                    'path' => $file,
                ],
                [
                    'content' => $content,
                    'view_name' => $viewName,
                ]
            );

            if ($viewName) {
                Cache::store('file')->pull("template_{$viewName}".$site->id);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $this->success(
            [
                'message' => trans('cms::app.save_successfully'),
            ]
        );
    }

    protected function getViewName($file)
    {
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        if ($extension != 'twig') {
            return null;
        }

        $view = str_replace('views/', '', $file);
        $view = str_replace('.twig', '', $view);
        $view = str_replace('/', '.', $view);

        return 'theme::'.$view;
    }

    protected function getThemeTree($folder, $sourcePath)
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
            if (!in_array($file->getExtension(), $this->supportExtensions)) {
                continue;
            }

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
}
