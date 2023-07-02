<?php

namespace Juzaweb\Backend\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Juzaweb\CMS\Contracts\HookActionContract;
use Juzaweb\CMS\Models\Model;
use Juzaweb\Network\Interfaces\RootNetworkModelInterface;
use Juzaweb\Network\Traits\RootNetworkModel;
use TwigBridge\Facade\Twig;

/**
 * Juzaweb\Backend\Models\EmailList
 *
 * @property int $id
 * @property string $email
 * @property int|null $template_id
 * @property string|null $template_code
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
 * @method static \Illuminate\Database\Eloquent\Builder|EmailList whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailList whereTemplate($code)
 * @property int|null $site_id
 * @method static Builder|EmailList whereTemplateCode($value)
 * @mixin \Eloquent
 */
class EmailList extends Model implements RootNetworkModelInterface
{
    use RootNetworkModel;

    protected $table = 'email_lists';

    protected $fillable = [
        'template_id',
        'template_code',
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

    public const STATUS_SUCCESS = 'success';
    public const STATUS_PENDING = 'pending';
    public const STATUS_CANCEL = 'cancel';
    public const STATUS_ERROR = 'error';

    public static function mapParams($string, $params = []): string
    {
        $temp = Twig::createTemplate($string);
        return $temp->render($params);
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(EmailTemplate::class, 'template_id', 'id');
    }

    public function scopeWhereTemplate(Builder $builder, string $code): Builder
    {
        return $builder->whereHas(
            'template',
            function ($q) use ($code) {
                $q->where('code', '=', $code);
            }
        );
    }

    public function getSubject(): string
    {
        $subject = Arr::get($this->data, 'subject');
        if (empty($subject)) {
            if ($this->template) {
                $subject = $this->template->subject;
            } else {
                $template = app(HookActionContract::class)
                    ->getEmailTemplates($this->template_code);
                $subject = $template->get('subject');
            }
        }

        return static::mapParams($subject, $this->params);
    }

    public function getBody(): string
    {
        $body = Arr::get($this->data, 'body');

        if (empty($body)) {
            if ($this->template) {
                $body = $this->template->body;
            } else {
                $template = app(HookActionContract::class)->getEmailTemplates($this->template_code);
                $body = File::get(view($template->get('body'))->getPath());
            }
        }

        return static::mapParams($body, $this->params);
    }
}
