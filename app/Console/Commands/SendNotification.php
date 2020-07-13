<?php

namespace App\Console\Commands;

use App\Models\EmailList;
use App\Models\MyNotification;
use App\User;
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
                
                if (!in_array($row->type, [2, 3])) {
                    continue;
                }
                
                $emails = User::whereIn('id', $users)
                    ->get();
                
                foreach ($emails as $email) {
                    $mail = new EmailList();
                    $mail->emails = $email;
                    $mail->params = json_encode([

                    ]);
                    
                }
            }
        }
    }
}
