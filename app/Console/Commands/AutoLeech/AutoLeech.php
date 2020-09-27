<?php

namespace App\Console\Commands\AutoLeech;

use Illuminate\Console\Command;

class AutoLeech extends Command
{
    protected $signature = 'auto:leech';
    
    protected $description = '';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function handle()
    {
        $this->call('leech:bilutv');
    }
}
