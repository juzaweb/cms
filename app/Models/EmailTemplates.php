<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\EmailTemplates
 *
 * @property int $id
 * @property string $code
 * @property string $subject
 * @property string|null $params
 * @property string $template_file
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplates newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplates newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplates query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplates whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplates whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplates whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplates whereParams($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplates whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplates whereTemplateFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplates whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EmailTemplates extends Model
{
    protected $table = 'email_templates';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',
        'template_file',
    ];
    
    public static function findCode(string $code) {
        return self::where('code', '=', $code)
            ->first();
    }
}
