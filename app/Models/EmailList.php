<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EmailList
 *
 * @property int $id
 * @property string $emails
 * @property string|null $params
 * @property int $template_id
 * @property string|null $error
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailList query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailList whereEmails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailList whereError($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailList whereParams($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailList whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailList whereTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailList whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EmailList extends Model
{
    protected $table = 'email_list';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',
        'params',
        'template',
    ];
}
