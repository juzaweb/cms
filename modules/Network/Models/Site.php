<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Network\Models;

use Juzaweb\CMS\Models\Model;

class Site extends Model
{
    const STATUS_ACTIVE = 'active';
    const STATUS_VERIFICATION = 'verification';
    const STATUS_BANNED = 'banned';

    protected $table = 'sites';

    protected $fillable = [
        'domain'
    ];

    public function getFieldName(): string
    {
        return 'domain';
    }
}
