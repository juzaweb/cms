<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Subscription\Models;

use Juzaweb\CMS\Models\Model;

/**
 * Juzaweb\Subscription\Models\PackageConfig
 *
 * @property int $id
 * @property int $package_id
 * @property string $code
 * @property string $value
 * @property-read \Juzaweb\Subscription\Models\Package $package
 * @method static \Illuminate\Database\Eloquent\Builder|PackageConfig newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageConfig newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageConfig query()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageConfig whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageConfig whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageConfig wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageConfig whereValue($value)
 * @mixin \Eloquent
 */
class PackageConfig extends Model
{
    public $timestamps = false;

    protected $table = 'package_configs';
    protected $guarded = ['id'];

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }
}
