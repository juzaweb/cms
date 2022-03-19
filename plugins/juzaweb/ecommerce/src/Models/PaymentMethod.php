<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Ecommerce\Models;

use Juzaweb\Models\Model;
use Juzaweb\Traits\ResourceModel;

/**
 * Juzaweb\Ecommerce\Models\PaymentMethod
 *
 * @property int $id
 * @property string $type
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $site_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Ecommerce\Models\Order[] $order
 * @property-read int|null $order_count
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PaymentMethod extends Model
{
    use ResourceModel;

    protected $table = 'payment_methods';
    protected $fieldName = 'name';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'data' => 'array'
    ];

    public function order()
    {
        return $this->hasMany(
            Order::class,
            'payment_method_id',
            'id'
        );
    }
}
