<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailList extends Model
{
    protected $table = 'email_list';
    protected $primaryKey = 'id';
    protected $fillable = [
        'subject',
        'params',
        'content',
    ];
    
    public function sendByTemplate($template_code) {
        $template = EmailTemplates::findCode($template_code);
        $this->subject = $template->subject;
        $this->content = $template->content;
        return $this->save();
    }
}
