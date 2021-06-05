<?php

namespace Mymo\Core\Console\Commands;

use Mymo\Core\Models\MyNotification;
use Mymo\Core\Models\User;
use Illuminate\Console\Command;

class SendNotification extends Command
{
    protected $signature = 'notify:send';
    
    protected $description = 'Command description';
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function handle()
    {
        $rows = MyNotification::where('status', '=', 2)
            ->limit(3)
            ->get();
     
        foreach ($rows as $row) {
            if ($row->users) {
                $users = explode(',', $row->users);
                $users = User::whereIn('id', $users)
                    ->get();
    
                \Notification::send($users, new \App\Notifications\SendNotification($row));
                
                MyNotification::where('id', $row->id)
                    ->update(['status' => 1]);
            }
            else {
                $users = User::where('status', '=', 1)
                    ->get();
                \Notification::send($users, new \App\Notifications\SendNotification($row));
                
                MyNotification::where('id', $row->id)
                    ->update(['status' => 1]);
            }
        }
    }
}
