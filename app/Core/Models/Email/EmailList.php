<?php

namespace App\Core\Models\Email;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Core\Models\Email\EmailList
 *
 * @property int $id
 * @property string $emails
 * @property string $subject
 * @property string $content
 * @property string|null $params
 * @property string|null $error
 * @property int $priority
 * @property int $status 1: sended, 2: pending, 3: cancel, 0: error
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Email\EmailList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Email\EmailList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Email\EmailList query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Email\EmailList whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Email\EmailList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Email\EmailList whereEmails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Email\EmailList whereError($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Email\EmailList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Email\EmailList whereParams($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Email\EmailList wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Email\EmailList whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Email\EmailList whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Email\EmailList whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
