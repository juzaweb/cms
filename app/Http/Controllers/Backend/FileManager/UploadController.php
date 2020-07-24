<?php

namespace App\Http\Controllers\Backend\Filemanager;

use App\Models\Files;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UploadController extends LfmController
{
    protected $errors;

    public function __construct()
    {
        parent::__construct();
        $this->errors = [];
    }
    
    public function upload()
    {
        $uploaded_files = request()->file('upload');
        $folder_id = request()->input('working_dir', null);
        
        if (empty($folder_id)) {
            $folder_id = null;
        }
        
        $error_bag = [];
        $new_filename = null;
        $new_path = null;
        
        foreach (is_array($uploaded_files) ? $uploaded_files : [$uploaded_files] as $file) {
            try {
                
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $new_filename = Str::slug(basename($filename, "." . $extension)) .'-'. time() .'-'. Str::random(10) .'.' . $extension;
                
                $storage = \Storage::disk('uploads');
                $new_path = $storage->putFileAs(date('Y/m/d'), $file, $new_filename, 'public');
                
                if ($new_path) {
                    $model = new Files();
                    $model->name = $filename;
                    $model->path = $new_path;
                    $model->type = 1;
                    $model->mime_type = $file->getClientMimeType();
                    $model->extension = $extension;
                    $model->size = $file->getSize();
                    $model->folder_id = $folder_id;
                    $model->user_id = \Auth::id();
                    $model->save();
                }
                
            } catch (\Exception $e) {
                Log::error($e->getMessage(), [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]);
                array_push($error_bag, $e->getMessage());
            }
        }

        if (is_array($uploaded_files)) {
            $response = count($error_bag) > 0 ? $error_bag : parent::$success_response;
        } else {
            // upload via ckeditor5 expects json responses
            if (is_null($new_filename)) {
                $response = ['error' =>
                    [
                        'message' =>  $error_bag[0]
                    ]
                ];
            } else {
                $url = \Storage::disk('uploads')->url($new_path);

                $response = [
                    'url' => $url
                ];
            }
        }

        return response()->json($response);
    }
}
