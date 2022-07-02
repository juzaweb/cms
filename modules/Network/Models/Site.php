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
use Juzaweb\Network\Interfaces\RootNetworkModelInterface;
use Juzaweb\Network\Traits\RootNetworkModel;

class Site extends Model implements RootNetworkModelInterface
{
    use RootNetworkModel;

    const STATUS_ACTIVE = 'active';
    const STATUS_VERIFICATION = 'verification';
    const STATUS_BANNED = 'banned';

    protected $table = 'network_sites';

    protected $fillable = [
        'domain'
    ];

    public function getFieldName(): string
    {
        return 'domain';
    }
}
