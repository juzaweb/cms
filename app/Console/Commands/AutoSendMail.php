<?php

namespace App\Console\Commands;

use App\Models\Configs;
use App\Models\EmailList;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;

class AutoSendMail extends Command
{
    protected $signature = 'email:send';
    
    protected $description = 'Command description';
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function handle()
    {
        $query = EmailList::where('status', '=', 2)
            ->orderBy('priority', 'DESC')
            ->limit(10);
        
        if (!$query->exists()) {
            return false;
        }
        
        $rows = $query->get();
        
        foreach ($rows as $row) {
            Mail::send('emails.template', [
                'content' => $this->mapParams($row->content, $row->params),
            ], function ($message) use ($row) {
                $message->to(explode(',', $row->emails))
                    ->subject($this->mapParams($row->subject, $row->params));
            });
    
            if (Mail::failures()) {
                EmailList::where('id', '=', $row->id)
                    ->update([
                        'error' => @json_encode(Mail::failures()),
                        'status' => 0,
                    ]);
                
                continue;
            }
    
            EmailList::where('id', '=', $row->id)
                ->update([
                    'status' => 1,
                ]);
        }
    }
    
    protected function mapParams($content, $params) {
        $params = json_decode($params);
        foreach ($params as $key => $param) {
            $content = str_replace('{'. $key .'}', $param, $content);
        }
        
        return $content;
    }
}
