<?php

namespace App\Console\Commands\Backup;

use App\Models\Backup\BackupServer;
use App\Models\Leech\LeechFile;
use Illuminate\Console\Command;
use Illuminate\Database\Query\Builder;

class BackupLeech extends Command
{
    protected $signature = 'backup:leech';
    
    protected $description = '';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function handle() {
        
        $servers = BackupServer::where('status', '=', 1)
            ->orderBy('order', 'ASC')
            ->get();
        
        foreach ($servers as $server) {
            $server_id = $server->id;
            $query = LeechFile::from('leech_files AS a')
                ->whereNotExists(function (Builder $builder) use ($server_id) {
                    $builder->select(['id'])
                        ->from('backup_histories')
                        ->where('file_id', '=', 'a.id')
                        ->where('server_id', '=', $server_id)
                        ->where('type', '=', 2);
                });
            
            if (!$query->exists()) {
                continue;
            }
            
            $files = $query->limit(1)->get();
            
            foreach ($files as $file) {
                $this->call("backup:server-{$server->server} {$server->id} {$file->id} 2");
            }
            
            break;
        }
    }
}
