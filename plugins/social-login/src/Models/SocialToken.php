<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\SocialLogin\Models;

use Juzaweb\CMS\Models\Model;
use Juzaweb\CMS\Models\User;

class SocialToken extends Model
{
    public $timestamps = false;

    protected $table = 'social_tokens';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
