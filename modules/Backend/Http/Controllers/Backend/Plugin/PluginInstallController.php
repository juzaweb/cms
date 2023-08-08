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
use Juzaweb\Backend\Events\AfterUploadPlugin;
use Juzaweb\Backend\Events\DumpAutoloadPlugin;
use Juzaweb\Backend\Support\PluginUploader;
use Juzaweb\CMS\Contracts\JuzawebApiContract;
use Juzaweb\CMS\Facades\Plugin;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class PluginInstallController extends BackendController
{
    public function index(): View
    {
        if (!config('juzaweb.plugin.enable_upload')) {
            abort(403, 'Access deny.');
        }

        $this->addBreadcrumb(
            [
                'url' => route('admin.plugin'),
                'title' => trans('cms::app.plugins')
            ]
        );

        $title = trans('cms::app.install');

        return view(
            'cms::backend.plugin.install',
            compact('title')
        );
    }

    public function getData(Request $request, JuzawebApiContract $api): object|array
    {
        if (!config('juzaweb.plugin.enable_upload')) {
            return (object) [];
        }

        $limit = $request->get('limit', 20);
        $page = $request->get('page', 1);
        $except = array_keys(Plugin::all());

        return $api->get(
            'plugins',
            [
                'limit' => $limit,
                'page' => $page,
                'except' => $except
            ]
        );
    }

    public function upload(Request $request): JsonResponse|RedirectResponse
    {
        if (!config('juzaweb.plugin.enable_upload')) {
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

                $plugin = app(PluginUploader::class)->upload($file);

                event(new DumpAutoloadPlugin());

                event(new AfterUploadPlugin($plugin));

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
