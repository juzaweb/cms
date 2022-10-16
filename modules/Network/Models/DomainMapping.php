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

class DomainMapping extends Model
{
    protected $table = 'network_domain_mappings';

    protected $fillable = [
        'domain',
        'site_id'
    ];
}
