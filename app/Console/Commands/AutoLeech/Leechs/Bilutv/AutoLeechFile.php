<?php

namespace App\Console\Commands\AutoLeech\Leechs\Bilutv;

use App\Models\Leech\LeechFile;
use App\Models\Leech\LeechLink;
use App\Traits\UseLeech;
use Illuminate\Console\Command;

class AutoLeechFile extends Command
{
    use UseLeech;
    
    protected $signature = 'leech:bilutv-file';
    
    protected $description = '';
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function handle()
    {
        $links = LeechLink::where('server', 'Bilutv')
            ->where('leech_link', '=', 2)
            ->limit(1)
            ->get();
        
        foreach ($links as $link) {
            $html = $this->getContent($link->link);
            $film_id = $this->find($html, '#film_id', 0)->value;
            $play_url = $this->find($html, 'a.btn-see', 0)->href;
            $episode_id = @explode('.', $play_url)[2];
            if ($film_id > 0 && $episode_id > 0) {
                $data = $this->post('https://bilutvz.org/ajax/player', [
                    'id' => $film_id,
                    'ep' => $episode_id,
                ]);
                
                $begin = strpos($data, '"file":"');
                $data = substr($data, $begin);
                $data = str_replace('"file":"', '', $data);
                $end = strpos($data, '"');
                $data = substr($data, 0, $end);
                
                if (is_url($data)) {
                    $newfile = LeechFile::create([
                        'leech_link_id' => $link->id,
                        'label' => 'S1',
                        'original_url' => $data,
                    ]);
    
                    if ($newfile) {
                        echo 'Leeched ' . $link->id . "\n";
    
                        $link->update([
                            'leech_link' => 1,
                        ]);
                    }
                    
                    continue;
                }
    
                $link->update([
                    'leech_link' => 0,
                    'error' => 'Cannot find link',
                ]);
    
                continue;
            }
        }
    }
}
