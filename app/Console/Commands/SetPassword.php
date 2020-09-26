<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class SetPassword extends Command
{
    protected $signature = 'set:password';
    
    protected $description = 'Command description';
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function handle()
    {
        $user = User::find(1);
        $user->setAttribute('password', \Hash::make(123456));
        dd($user->save());
    }
}
