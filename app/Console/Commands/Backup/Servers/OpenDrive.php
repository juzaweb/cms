<?php

namespace App\Console\Commands\Backup\Servers;

use App\Models\Backup\BackupHistory;
use App\Models\Backup\BackupServer;
use App\Models\Leech\LeechFile;
use App\Models\VideoFiles;
use Illuminate\Console\Command;
use App\Helpers\OpenDriveApi;

class OpenDrive extends Command
{
    protected $signature = 'backup:server-opendrive {server} {file} {type}';
    
    protected $description = '';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function handle()
    {
        $server_id = $this->argument('server');
        $file_id = $this->argument('file');
        $type = $this->argument('type');
    
        $server = BackupServer::find($server_id);
        if ($type == 1) {
            $file = VideoFiles::find($file_id);
            
        }
        else {
            $file = LeechFile::find($file_id);
            $file_name = $file->label;
            $file_path = \Storage::disk('local')->path($file->local_path);
        }
        
        if (empty($server) || empty($file)) {
            return false;
        }
        
        $data = json_decode($server->data, true);
        $api = new OpenDriveApi();
        $api->Login($data['username'], $data['password'], $data['partner_id']);
        
        if (empty($api->sessionid)) {
            return false;
        }
        
        $history = BackupHistory::firstOrNew(['file_id' => $file->id, 'type' => $type]);
        $history->file_id = $file->id;
        $history->server_id = $server->id;
        $history->type = $type;
        $history->save();
        
        $folder = isset($data['folder_id']) ? $data['folder_id'] : '';
        echo "UPLOAD FILE {$file->id} TO SERVER {$server->name} \n";
        
        $upload_folder = $api->GetFolderByPath('backup-files/' . date('Y-m-d'));
        if (empty($upload_folder)) {
            $upload_folder = $api->CreateFolder($folder, $file_name);
        }
        
        $result = $api->UploadFile($upload_folder, $file_name, $file_path);
        $FileId = $result['body']['Link'];
        $FileId = explode('/', $FileId)[count(explode('/', $FileId)) - 1];
    
        $Size = $result['body']['Size'];
        if ($Size === \File::size($file_path)) {
        
        }
        else {
            $history->error = 'size_not_equal';
            $history->save();
        }
    }
}
