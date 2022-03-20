<?php

namespace Juzaweb\Backend\Models;

use Illuminate\Support\Arr;
use TwigBridge\Facade\Twig;
use Juzaweb\Models\Model;

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
