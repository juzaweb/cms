<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServerStream extends Model
{
    protected $table = 'server_streams';
    protected $fillable = [
        'name',
    ];
    
    public function getLinkStream() {
    
    }
}
