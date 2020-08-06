<?php

namespace App\Console\Commands;

use App\Models\VideoFiles;
use App\User;
use Illuminate\Console\Command;

class VideoConvert extends Command
{
    protected $signature = 'video:convert';
    protected $description = '';
    protected $ffmpeg_path;
    protected $qualities;
    protected $hls_video;
    protected $convert_speed;
    
    public function __construct()
    {
        parent::__construct();
        $this->ffmpeg_path = '';
        $qualities = get_config('video_convert_quality');
        $qualities = $qualities ? explode(',', $qualities) : null;
        $this->qualities = $qualities;
        $this->hls_video = get_config('hls_video');
    }
    
    public function handle()
    {
        if (!get_config('video_convert')) {
            return false;
        }
        
        if (empty($this->qualities)) {
            return false;
        }
        
        $video_files = VideoFiles::where('source', 'upload')
            ->where('converted', '=', 0)
            ->limit(1)
            ->get();
        $storage = \Storage::disk('uploads');
        
        foreach ($video_files as $video_file) {
            if ($storage->exists($video_file->url)) {
                $video_file->update([
                    'converted' => 2,
                ]);
                
                $video_res = 0;
                foreach ($this->qualities as $quality) {
                    $scale = $this->getScaleByQuality($quality);
                    if ($video_res >= $scale || $video_res == 0) {
                        $result = $this->convertVideo($storage->path($video_file->url), $quality, $scale);
                        if ($result) {
                            $video_file->update([
                                'video_' . $quality => $result,
                            ]);
                        }
                    }
                }
    
                $video_file->update([
                    'converted' => 1,
                ]);
            }
            else {
                $video_file->update([
                    'converted' => 3,
                ]);
            }
        }
    }
    
    private function convertVideo($video_path, $quality, $scale) {
        if ($this->hls_video) {
            return $this->hlsConvert($video_path, $quality, $scale);
        }
        
        return $this->videoFileConvert($video_path, $quality, $scale);
    }
    
    private function hlsConvert($video_path, $quality, $scale) {
    
    }
    
    private function videoFileConvert($video_path, $quality, $scale) {
        try {
            $file_path = date('Y/m/d') . '/' . 'converted_'. $quality .'_' . basename($video_path);
            $output_path = \Storage::disk('uploads')->path($file_path);
            shell_exec("$this->ffmpeg_path -y -i $video_path -vcodec libx264 -preset {$this->convert_speed} -filter:v scale=". $scale .":-2 -crf 26 $output_path 2>&1");
        
            return $file_path;
        }
        catch (\Exception $exception) {
            \Log::error('VideoConvert: ' . $exception->getFile() . ' - Line '. $exception->getLine(). ': '. $exception->getMessage());
            return false;
        }
    }
    
    private function getScaleByQuality($quality) {
        switch ($quality) {
            case '240p': $scale = 426;break;
            case '360p': $scale = 640;break;
            case '480p': $scale = 854;break;
            case '720p': $scale = 1280;break;
            case '1080p': $scale = 1920;break;
            case '2048p': $scale = 2048;break;
            case '4096p': $scale = 3840;break;
            default: $scale = '';
        }
        
        return $scale;
    }
}
