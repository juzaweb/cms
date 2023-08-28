<?php

namespace Juzaweb\Backend\Http\Controllers\FileManager;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Juzaweb\Backend\Events\UploadFileSuccess;
use Juzaweb\Backend\Http\Requests\FileManager\ImportRequest;
use Juzaweb\CMS\Support\FileManager;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class UploadController extends FileManagerController
{
    protected array $errors = [];

    public function upload(Request $request): JsonResponse
    {
        $folderId = $request->input('working_dir');
        $disk = $request->input('disk') ?? config('juzaweb.filemanager.disk');

        if (!in_array($disk, ['public', 'protected', 'tmp'])) {
            return $this->responseUpload([trans('cms::message.invalid_disk') ]);
        }

        if (empty($folderId)) {
            $folderId = null;
        }

        try {
            $receiver = new FileReceiver('upload', $request, HandlerFactory::classFromRequest($request));
            if ($receiver->isUploaded() === false) {
                throw new UploadMissingFileException();
            }

            $save = $receiver->receive();
            if ($save->isFinished()) {
                $file = FileManager::addFile(
                    $save->getFile(),
                    $this->getType(),
                    $folderId,
                    null,
                    $disk
                );

                event(new UploadFileSuccess($file));

                return $this->responseUpload($this->errors);
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
            $this->errors[] = $e->getMessage();
            return $this->responseUpload($this->errors);
        }
    }

    public function import(ImportRequest $request): JsonResponse|RedirectResponse
    {
        if (!config('juzaweb.filemanager.upload_from_url')) {
            abort(403);
        }

        $folderId = $request->input('working_dir');
        $download = (bool) $request->input('download');
        $disk = $request->input('disk') ?? config('juzaweb.filemanager.disk');

        if (empty($folderId)) {
            $folderId = null;
        }

        if (!in_array($disk, ['public', 'protected', 'tmp'])) {
            return $this->responseUpload([trans('cms::message.invalid_disk') ]);
        }

        DB::beginTransaction();
        try {
            $file = FileManager::make($request->input('url'));
            $file->setType($this->getType());
            $file->setFolder($folderId);
            $file->setDownloadFileUrlToServer($download);
            $file->setDisk($disk);
            $file->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return $this->error($e->getMessage());
        }

        return $this->success(trans('cms::message.upload_successfull'));
    }

    protected function responseUpload($error): JsonResponse
    {
        $response = count($error) > 0 ? $error : parent::$success_response;

        return response()->json($response, $error ? 422 : 200);
    }
}
