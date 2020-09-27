<?php

namespace App\Console\Commands\AutoLeech\Leechs\Bilutv;

use App\Models\Movies;
use Illuminate\Console\Command;
use App\Models\Leech\LeechLink;
use App\Traits\UseLeech;

class AutoLeechLink extends Command
{
    use UseLeech;
    
    protected $signature = 'leech:bilutv-link';
    
    protected $description = 'Command description';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function handle()
    {
        $url = 'https://bilutvz.org/danh-sach/phim-le';
        $html = $this->getContent($url);
        $movies = $this->find($html, '.film-item a');
    
        foreach ($movies as $movie) {
            if (LeechLink::where('link', trim($movie->href))->exists()) {
                continue;
            }
        
            $name = $this->plaintext($movie->innertext(), '.real-name');
            $name = $this->getMovieName($name);
        
            if ($this->nameExists($name)) {
                continue;
            }
            
            $newmovie = LeechLink::create([
                'name' => $name,
                'link' => trim($movie->href),
                'server' => 'bilutv',
                'tv_series' => 0,
            ]);
        
            if ($newmovie) {
                echo 'Leeched ' . $name . "\n";
            }
        }
    }
    
    protected function nameExists($name) {
        if (LeechLink::where('link', $name)->exists()) {
            return true;
        }
        
        if (Movies::where('name', '=', $name)->exists()) {
            return true;
        }
        
        return false;
    }
}
