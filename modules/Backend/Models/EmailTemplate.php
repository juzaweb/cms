<?php

namespace Juzaweb\Backend\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Juzaweb\CMS\Models\Model;
use Juzaweb\CMS\Models\User;
use Juzaweb\CMS\Traits\Models\UseCodeColumn;
use Juzaweb\CMS\Traits\ResourceModel;
use Juzaweb\CMS\Traits\UseUUIDColumn;

/**
 * Juzaweb\Backend\Models\EmailTemplate
 *
 * @property int $id
 * @property string $code
 * @property string $subject
 * @property string $body
 * @property array|null $params
 * @property string|null $layout
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $email_hook
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate whereEmailHook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate whereFilter($params = [])
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate whereLayout($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate whereParams($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate whereUpdatedAt($value)
 * @property int|null $site_id
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate whereSiteId($value)
 * @property string|null $uuid
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate whereUuid($value)
 * @property bool $active
 * @property bool $to_sender
 * @property array|null $to_emails
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate whereToEmails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate whereToSender($value)
 * @mixin \Eloquent
 */
class EmailTemplate extends Model
{
    use ResourceModel, UseUUIDColumn, UseCodeColumn;

    protected string $fieldName = 'subject';
    protected $table = 'email_templates';
    protected $fillable = [
        'code',
        'subject',
        'body',
        'params',
        'email_hook',
        'to_sender',
        'to_emails',
        'active',
    ];

    protected $casts = [
        'params' => 'array',
        'to_emails' => 'array',
        'to_sender' => 'boolean',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'email_template_users', 'email_template_id', 'user_id');
    }

    public function getToEmailsArrtribute(): array
    {
        return collect($this->to_emails)
            ->unique()
            ->filter(fn($email) => !empty($email))
            ->toArray();
    }
}
