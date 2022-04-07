<?php

namespace Juzaweb\Backend\Models;

use Illuminate\Support\Arr;
use TwigBridge\Facade\Twig;
use Juzaweb\CMS\Models\Model;

/**
 * Juzaweb\Backend\Models\EmailList
 *
 * @property int $id
 * @property string $email
 * @property int|null $template_id
 * @property array|null $params
 * @property string $status pending => processing => (success || error)
 * @property int $priority
 * @property array|null $error
 * @property array|null $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Juzaweb\Backend\Models\EmailTemplate|null $template
 * @method static \Illuminate\Database\Eloquent\Builder|EmailList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailList query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailList whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailList whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailList whereError($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailList whereParams($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailList wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailList whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailList whereTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailList whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EmailList extends Model
{
    protected $table = 'email_lists';
    protected $fillable = [
        'template_id',
        'email',
        'priority',
        'params',
        'status',
        'error',
        'data',
    ];

    protected $casts = [
        'params' => 'array',
        'data' => 'array',
        'error' => 'array',
    ];

    const STATUS_SUCCESS = 'success';
    const STATUS_PENDING = 'pending';
    const STATUS_CANCEL = 'cancel';
    const STATUS_ERROR = 'error';

    public static function mapParams($string, $params = [])
    {
        $temp = Twig::createTemplate($string);
        return $temp->render($params);
    }

    public function template()
    {
        return $this->belongsTo(EmailTemplate::class, 'template_id', 'id');
    }

    public function getSubject()
    {
        $subject = Arr::get($this->data, 'subject');
        if (empty($subject)) {
            $subject = $this->template->subject;
        }

        return static::mapParams($subject, $this->params);
    }

    public function getBody()
    {
        $body = Arr::get($this->data, 'body');
        if (empty($body)) {
            $body = $this->template->body;
        }

        return static::mapParams($body, $this->params);
    }
}
