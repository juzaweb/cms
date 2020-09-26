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
        $path = \Storage::disk('local')->path('leech/' . date('Y_m_d'));
        $files = LeechFile::where('status', '=', 2)
            ->limit(1)
            ->get();
        
        foreach ($files as $file) {
            $file->update([
                'status' => 3,
            ]);
            
            if (!$this->checkAccess()) {
                $file->update([
                    'status' => 0,
                    'error' => 'File not access',
                ]);
                
                continue;
            }
    
            $filename = $path . '/' . $this->generateFileName();
            $this->downloadChunk($file->original_url, $filename);
    
            if (\Storage::size($filename) <= 2) {
                $file->update([
                    'status' => 0,
                    'error' => 'Cannot download file',
                ]);
                
                continue;
            }
    
            $file->update([
                'status' => 1,
            ]);
        }
    }
    
    
}
