<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Network\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Juzaweb\CMS\Models\Model;
use Juzaweb\Network\Interfaces\RootNetworkModelInterface;
use Juzaweb\Network\Traits\RootNetworkModel;

/**
 * Juzaweb\Network\Models\Site
 *
 * @property int $id
 * @property string $domain
 * @property string $status
 * @property int|null $db_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Site newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Site newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Site query()
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereDbId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Network\Models\DomainMapping[] $domainMappings
 * @property-read int|null $domain_mappings_count
 */
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

    public function domainMappings(): HasMany
    {
        return $this->hasMany(DomainMapping::class, 'site_id', 'id');
    }

    public function getFullDomain(): string
    {
        return $this->domain .'.'. config('network.domain');
    }

    public function getSiteUrl(string $path = null): string
    {
        return 'http://' . $this->getFullDomain() . '/'. ltrim($path, '/');
    }

    public function getFieldName(): string
    {
        return 'domain';
    }
}
