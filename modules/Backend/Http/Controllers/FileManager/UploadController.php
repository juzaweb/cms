<?php

namespace Juzaweb\Backend\Http\Controllers\FileManager;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
                FileManager::addFile(
                    $save->getFile(),
                    $this->getType(),
                    $folderId
                );
                // event
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

    protected function responseUpload($error): JsonResponse
    {
        $response = count($error) > 0 ? $error : parent::$success_response;

        return response()->json($response, $error ? 422 : 200);
    }
}
