<?php

namespace Juzaweb\Subscription\Models;

use Illuminate\Database\Eloquent\Model;
use Juzaweb\CMS\Models\User;

/**
 * Juzaweb\Subscription\Models\UserSubscription
 *
 * @property int $id
 * @property string $module
 * @property string $method
 * @property string $agreement_id
 * @property string $amount
 * @property int $user_id
 * @property int|null $package_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Juzaweb\Subscription\Models\Package|null $package
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubscription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubscription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubscription query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubscription whereAgreementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubscription whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubscription whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubscription whereModule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubscription wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubscription whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubscription whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubscription whereUserId($value)
 * @mixin \Eloquent
 * @property string $next_payment
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubscription whereNextPayment($value)
 */
class UserSubscription extends Model
{
    protected $table = 'user_subscriptions';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function package()
    {
        return $this->belongsTo(
            Package::class,
            'package_id',
            'id'
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
