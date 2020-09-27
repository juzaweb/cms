<?php

namespace App\Console\Commands\AutoLeech\Leechs;


use Illuminate\Console\Command;

class BilutvLeech extends Command
{
    protected $signature = 'leech:bilutv';
    
    protected $description = '';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function handle() {
        $this->call('leech:bilutv-link');
        $this->call('leech:bilutv-data');
    }
}
