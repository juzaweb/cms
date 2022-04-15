<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Ecommerce\Models;

use Juzaweb\CMS\Models\Model;
use Juzaweb\CMS\Models\User;

class Cart extends Model
{
    protected $table = 'carts';
    protected $casts = [
        'items' => 'array'
    ];
    
    protected $fillable = [
        'code',
        'items'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
