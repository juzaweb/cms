<?php

namespace App\Console\Commands\AutoLeech;

use App\Models\Leech\LeechFile;
use App\Traits\UseDownloadFile;
use Illuminate\Console\Command;

class AutoDownloadFile extends Command
{
    use UseDownloadFile;
    
    protected $signature = 'autoleech:download';
    
    protected $description = '';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function handle() {
        $storage_path = \Storage::disk('local')->path('');
        $filepath = 'leech/' . date('Y_m_d');
        if (!is_dir($storage_path . $filepath)) {
            \File::makeDirectory($storage_path . $filepath);
        }
        
        $files = LeechFile::where('status', '=', 2)
            ->limit(1)
            ->get();
        
        foreach ($files as $file) {
            $file->update([
                'status' => 3,
            ]);
            
            if (!$this->checkAccess($file->original_url)) {
                $file->update([
                    'status' => 0,
                    'error' => 'File not access',
                ]);
                
                continue;
            }
    
            $filepath = $filepath .'/'. $this->generateFileName($file->original_url);
            $filename = $storage_path . '/' . $filepath;
            $this->downloadChunk($file->original_url, $filename);
    
            if (\File::size($filename) <= 2) {
                $file->update([
                    'status' => 0,
                    'error' => 'Cannot download file',
                ]);
                
                continue;
            }
    
            $file->update([
                'status' => 1,
                'local_path' => $filepath,
            ]);
        }
    }
    
    
}
