<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Configs
 *
 * @property int $id
 * @property string $key
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Configs newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Configs newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Configs query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Configs whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Configs whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Configs whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Configs whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Configs whereValue($value)
 * @mixin \Eloquent
 */
class Configs extends Model
{
    protected $table = 'configs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name'
    ];
    
    public static function getConfig($key) {
        $config = Configs::firstOrNew(['key' => $key]);
        return $config->value;
    }
    
    public static function setConfig($key, $value = null) {
        $config = Configs::firstOrNew(['key' => $key]);
        $config->value = $value;
        return $config->save();
    }
}
