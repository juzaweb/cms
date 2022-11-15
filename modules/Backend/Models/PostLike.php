<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Backend\Models;

use Juzaweb\CMS\Models\Model;

class PostLike extends Model
{
    protected $table = 'post_likes';
    protected $fillable = [
        'post_id',
        'user_id',
        'client_ip'
    ];
}
