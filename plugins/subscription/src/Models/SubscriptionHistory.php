<?php

namespace Juzaweb\Subscription\Models;

use Juzaweb\CMS\Models\User;
use Juzaweb\CMS\Models\Model;

/**
 * Juzaweb\Subscription\Models\SubscriptionHistory
 *
 * @property int $id
 * @property string $token
 * @property string $method
 * @property string $agreement_id
 * @property string $amount
 * @property string $module
 * @property string|null $payer_id
 * @property string|null $payer_email
 * @property int $user_id
 * @property int $package_id
 * @property int|null $object_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Juzaweb\Subscription\Models\Package $package
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionHistory whereAgreementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionHistory whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionHistory whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionHistory whereModule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionHistory whereObjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionHistory wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionHistory wherePayerEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionHistory wherePayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionHistory whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionHistory whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionHistory whereUserId($value)
 * @mixin \Eloquent
 */
class SubscriptionHistory extends Model
{
    protected $table = 'subscription_histories';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

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
        return $this->belongsTo(
            User::class,
            'user_id',
            'id'
        );
    }
}
