<?php

namespace App\Console\Commands\AutoLeech\Leechs\Bilutv;

use App\Traits\UseLeech;
use Illuminate\Console\Command;

class AutoLeechData extends Command
{
    use UseLeech;
    
    protected $signature = 'leech:bilutv-data';
    
    protected $description = '';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function handle() {
    
    }
    
    protected function leeckFiles($url) {
        $html = $this->getContent($url);
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
                return [
                    'status' => true,
                    'data' => [
                        'files' => [
                            [
                                'label' => 'S1',
                                'url' => $data,
                            ]
                        ]
                    ]
                ];
            }
    
            return [
                'status' => false,
                'data' => [
                    'error' => 'Cannot find link'
                ],
            ];
        }
    }
}
