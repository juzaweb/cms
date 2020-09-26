<?php

namespace App\Console\Commands\AutoLeech;

use App\Traits\UseDownloadFile;
use Illuminate\Console\Command;

class TestDownload extends Command
{
    use UseDownloadFile;
    
    protected $signature = 'test:download';
    
    protected $description = 'Command description';
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function handle() {
        $url = "https://scontent-hel3-1.xx.fbcdn.net/v/t66.36240-6/10000000_3563522293690791_1468434051186248497_n.mp4?_nc_cat=104&_nc_sid=985c63&efg=eyJ2ZW5jb2RlX3RhZyI6Im9lcF9oZCJ9&_nc_ohc=MRMfcPre4FQAX9UpqFF&_nc_ht=scontent-hel3-1.xx&oh=6b5172980eee84997771f307528a695a&oe=5F93E5E6";
    
        dd($this->checkActive($url));
        $this->downloadChunk($url, storage_path('test.mp4'));
    }
    
    
}
