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
use Juzaweb\Backend\Events\AfterUploadTheme;
use Juzaweb\Backend\Support\ThemeUploader;
use Juzaweb\CMS\Contracts\JuzawebApiContract;
use Juzaweb\CMS\Facades\ThemeLoader;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class ThemeInstallController extends BackendController
{
    public function index(): View
    {
        if (!config('juzaweb.theme.enable_upload')) {
            abort(403, 'Access deny.');
        }

        $title = trans('cms::app.add_new');

        $this->addBreadcrumb(
            [
                'title' => trans('cms::app.themes'),
                'url' => route('admin.themes')
            ]
        );

        return $this->view('cms::backend.theme.install', compact('title'));
    }

    public function getData(Request $request, JuzawebApiContract $api): object|array
    {
        if (!config('juzaweb.theme.enable_upload')) {
            return (object) [];
        }

        $limit = $request->get('limit', 20);
        $page = $request->get('page', 1);
        $except = array_keys(ThemeLoader::all(true));

        return $api->get(
            'themes',
            [
                'limit' => $limit,
                'page' => $page,
                'except' => $except
            ]
        );
    }

    public function upload(Request $request): JsonResponse|RedirectResponse
    {
        if (!config('juzaweb.theme.enable_upload')) {
            abort(403, 'Access deny.');
        }

        try {
            $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));
            if ($receiver->isUploaded() === false) {
                throw new UploadMissingFileException();
            }

            $save = $receiver->receive();
            if ($save->isFinished()) {
                $file = $save->getFile();

                $theme = app(ThemeUploader::class)->upload($file);

                event(new AfterUploadTheme($theme));

                return $this->success(trans('cms::message.upload_successfull'));
            }

            $handler = $save->handler();

            return response()->json(
                [
                    "done" => $handler->getPercentageDone(),
                    'status' => true,
                ]
            );
        } catch (\Exception $e) {
            report($e);
            return $this->error($e->getMessage());
        }
    }
}
