<?php

namespace Juzaweb\Backend\Models;

use Juzaweb\CMS\Models\Model;

/**
 * Juzaweb\Backend\Models\PasswordReset
 *
 * @property string $email
 * @property string $token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Backend\Models\PasswordReset newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Backend\Models\PasswordReset newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Backend\Models\PasswordReset query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Backend\Models\PasswordReset whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Backend\Models\PasswordReset whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Juzaweb\Backend\Models\PasswordReset whereToken($value)
 * @mixin \Eloquent
 */
class PasswordReset extends Model
{
    protected $primaryKey = 'email';
    protected $keyType = 'string';

    protected $table = 'password_resets';
    protected $fillable = [
        'email',
        'token'
    ];

    public const UPDATED_AT = null;
}
