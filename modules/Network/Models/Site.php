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
    const STATUS_INACTIVE = 'inactive';
    const STATUS_VERIFICATION = 'verification';
    const STATUS_BANNED = 'banned';

    protected $table = 'network_sites';

    protected $fillable = [
        'domain',
        'status'
    ];

    public static function getAllStatus(): array
    {
        return [
            self::STATUS_ACTIVE => trans('cms::app.active'),
            self::STATUS_INACTIVE => trans('cms::app.active'),
            self::STATUS_VERIFICATION => trans('cms::app.verification'),
            self::STATUS_BANNED => trans('cms::app.banned'),
        ];
    }

    public function getFieldName(): string
    {
        return 'domain';
    }
}
