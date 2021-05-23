<?php

namespace App\Http\Controllers\Backend\FileManager;

use App\Models\Files;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Illuminate\Http\UploadedFile;

class UploadController extends LfmController
{
    protected $errors;

    public function __construct() {
        parent::__construct();
        $this->errors = [];
    }
    
    public function upload(Request $request)
    {
        $folder_id = request()->input('working_dir');
        
        if (empty($folder_id)) {
            $folder_id = null;
        }
        
        $error_bag = [];
        $new_filename = null;
        $new_path = null;
    
        try {
    
            $receiver = new FileReceiver('upload', $request, HandlerFactory::classFromRequest($request));
            if ($receiver->isUploaded() === false) {
                throw new UploadMissingFileException();
            }
            
            $save = $receiver->receive();
            if ($save->isFinished()) {
                $this->saveFile($save->getFile(), $folder_id);
                return $this->response($error_bag);
            }
    
            $handler = $save->handler();
    
            return response()->json([
                "done" => $handler->getPercentageDone(),
                'status' => true
            ]);
        
        } catch (\Exception $e) {
            Log::error($e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
        
            array_push($error_bag, $e->getMessage());
            return $this->response($error_bag);
        }
    }
    
    protected function saveFile(UploadedFile $file, $folder_id) {
        $filename = $this->createFilename($file);
        $storage = \Storage::disk('public');
        $new_path = $storage->putFileAs(date('Y/m/d'), $file, $filename);
    
        if ($new_path) {
            $model = new Files();
            $model->name = $file->getClientOriginalName();
            $model->path = $new_path;
            $model->type = $this->getType();
            $model->mime_type = $file->getClientMimeType();
            $model->extension = $file->getClientOriginalExtension();
            $model->size = $file->getSize();
            $model->folder_id = $folder_id;
            $model->user_id = \Auth::id();
            $model->save();
        }
        
        return $new_path;
    }
    
    protected function createFilename(UploadedFile $file) {
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $new_filename = Str::slug(basename($filename, "." . $extension)) .'-'. time() .'-'. Str::random(10) .'.' . $extension;
        return $new_filename;
    }
    
    protected function response($error_bag) {
        $response = count($error_bag) > 0 ? $error_bag : parent::$success_response;
        return response()->json($response);
    }
}
