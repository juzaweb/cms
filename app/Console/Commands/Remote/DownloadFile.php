<?php

namespace App\Console\Commands\Remote;

use App\Models\Video\VideoFiles;
use App\Traits\UseDownloadFile;
use Illuminate\Console\Command;
use Illuminate\Database\Query\Builder;

class DownloadFile extends Command
{
    use UseDownloadFile;
    
    protected $signature = 'remote:download';
    
    protected $description = '';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function handle() {
        $storage_path = \Storage::disk('local')->path('');
        $filepath = date('Y/m/d');
        
        if (!is_dir($storage_path . $filepath)) {
            \File::makeDirectory($storage_path . $filepath, 775, true);
        }
        
        $files = VideoFiles::where('enable_remote', '=', 1)
            ->where(function (Builder $builder) {
                $builder->orWhere('url', 'like', 'http://%');
                $builder->orWhere('url', 'like', 'https://%');
            })
            ->whereNotExists(function (Builder $builder) {
                $builder->select(['id'])
                    ->from('download_remote_histories')
                    ->whereColumn('video_file_id', '=', 'a.id');
            })
            ->limit(1)
            ->get();
        
        foreach ($files as $file) {
            
            $history_id = \DB::table('remote_histories')
                ->insertGetId([
                    'video_file_id' => $file->id,
                    'download_status' => 2,//downloading
                ]);
            
            if (!$this->checkAccess($file->url)) {
                \DB::table('remote_histories')
                    ->where('id', '=', $history_id)
                    ->update([
                        'download_status' => 0,
                        'error' => 'Cannot access file.',
                    ]);
                
                continue;
            }
    
            $filepath = $filepath .'/'. $this->generateFileName($file->url);
            $filename = $storage_path . '/' . $filepath;
            $this->downloadFile($file, $filename);
    
            if (\File::size($filename) <= 2) {
                \DB::table('remote_histories')
                    ->where('id', '=', $history_id)
                    ->update([
                        'download_status' => 0,
                        'error' => 'Cannot download file.',
                    ]);
                
                continue;
            }
    
            $file->update([
                'url' => $filepath,
            ]);
            
            \DB::table('remote_histories')
                ->where('id', '=', $history_id)
                ->update([
                    'download_status' => 1,
                ]);
        }
    }
    
    protected function downloadFile($file, $filename) {
        $this->downloadChunk($file->url, $filename);
    }
}
