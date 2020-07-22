<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplates extends Model
{
    protected $table = 'email_templates';
    protected $primaryKey = 'id';
    protected $fillable = [
        'subject',
        'content',
    ];
    
    public static function findCode(string $code) {
        return self::where('code', '=', $code)
            ->first();
    }
}
