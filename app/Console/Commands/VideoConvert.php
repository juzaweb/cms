<?php

namespace App\Console\Commands;

use App\Models\Video\VideoFiles;
use Illuminate\Console\Command;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Streaming\FFMpeg;

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
    
    public function handle() {
        
        $video_files = VideoFiles::where('source', 'upload')
            ->where('converted', '=', 0)
            ->limit(1)
            ->get();
        $storage = \Storage::disk('uploads');
        
        foreach ($video_files as $video_file) {
            if ($storage->exists($video_file->url)) {
    
                $config = [
                    'ffmpeg.binaries'  => '/usr/bin/ffmpeg',
                    'ffprobe.binaries' => '/usr/bin/ffprobe',
                    'timeout'          => 3600,
                    'ffmpeg.threads'   => 12,
                ];
    
                $log = new Logger('FFmpeg_Streaming');
                $log->pushHandler(new StreamHandler('/var/log/ffmpeg-streaming.log'));
    
                $ffmpeg = FFMpeg::create($config, $log);
                
            }
            else {
            
            }
        }
    }
}
