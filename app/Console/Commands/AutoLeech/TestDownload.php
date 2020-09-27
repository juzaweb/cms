<?php

namespace App\Console\Commands\AutoLeech;

use App\Traits\UseDownloadFile;
use Illuminate\Console\Command;

class TestDownload extends Command
{
    use UseDownloadFile;
    
    protected $signature = 'autoleech:test';
    
    protected $description = 'Command description';
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function handle() {
        $url = "https://api.fptplay.net/api/v6.2_w/stream/vod/5f5ff1fd2089bd1d46ea3985/0/1080p?st=0_4PBc7MuE-gajhjffn4Tg&e=1601197389213&device=Chrome(version:85)";
        
        $this->downloadChunk($url, storage_path('test.m3u8'));
    }
}
