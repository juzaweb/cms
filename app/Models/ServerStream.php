<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServerStream extends Model
{
    protected $table = 'server_streams';
    protected $fillable = [
        'key',
        'name',
        'base_url',
        'priority',
        'status',
    ];
    
    public function getLinkStream() {
    
    }
}
