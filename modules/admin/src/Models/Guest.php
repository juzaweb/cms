<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://cms.juzaweb.com
 */

namespace Juzaweb\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Notifications\Notifiable;
use Juzaweb\Modules\Core\Models\Model;
use Juzaweb\Modules\Core\Notifications\Traits\Subscriptable;

class Guest extends Model
{
    use HasUuids, Notifiable, Subscriptable;

    protected $table = 'guests';

    protected $fillable = [
        'ipv4',
        'ipv6',
        'user_agent',
        'name',
        'email',
    ];

    protected $casts = [
        'data' => 'array',
    ];
}
