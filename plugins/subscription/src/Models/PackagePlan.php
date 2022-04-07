<?php

namespace Juzaweb\Subscription\Models;

use Juzaweb\CMS\Models\Model;

/**
 * Juzaweb\Subscription\Models\PackagePlan
 *
 * @property int $id
 * @property string $method
 * @property string $plan_id
 * @property int $package_id
 * @property-read \Juzaweb\Subscription\Models\Package $package
 * @method static \Illuminate\Database\Eloquent\Builder|PackagePlan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PackagePlan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PackagePlan query()
 * @method static \Illuminate\Database\Eloquent\Builder|PackagePlan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackagePlan whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackagePlan wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackagePlan wherePlanId($value)
 * @mixin \Eloquent
 * @property string|null $product_id
 * @method static \Illuminate\Database\Eloquent\Builder|PackagePlan whereProductId($value)
 */
class PackagePlan extends Model
{
    public $timestamps = false;

    protected $table = 'package_plans';
    protected $guarded = ['id'];

    public function package()
    {
        return $this->belongsTo(
            Package::class,
            'package_id',
            'id'
        );
    }
}
