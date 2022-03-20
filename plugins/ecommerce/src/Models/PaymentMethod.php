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
