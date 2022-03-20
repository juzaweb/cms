<?php

namespace Juzaweb\Subscription\Models;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Juzaweb\Models\Model;
use Juzaweb\Backend\Facades\HookAction;
use Juzaweb\Traits\ResourceModel;
use Ramsey\Uuid\Uuid;

/**
 * Juzaweb\Subscription\Models\Package
 *
 * @property int $id
 * @property string $name
 * @property string $price
 * @property int $period
 * @property string $period_unit
 * @property array|null $data
 * @property int|null $site_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Subscription\Models\PackageConfig[] $configs
 * @property-read int|null $configs_count
 * @method static \Illuminate\Database\Eloquent\Builder|Package newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Package newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Package query()
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package wherePeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package wherePeriodUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $description
 * @property string $module
 * @property int $status
 * @property bool $is_free
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Subscription\Models\PackagePlan[] $plans
 * @property-read int|null $plans_count
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereFilter($params = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereIsFree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereModule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereStatus($value)
 * @property string $key
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereKey($value)
 */
class Package extends Model
{
    use ResourceModel;

    protected $table = 'packages';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'data' => 'array'
    ];

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->key = Uuid::uuid4()->toString();
        });
    }

    public static function getAllStatus()
    {
        return [
            static::STATUS_ENABLED => trans('cms::app.enabled'),
            static::STATUS_DISABLED => trans('cms::app.disabled'),
        ];
    }

    public static function findByKey(string $key)
    {
        return self::where('key', $key)->first();
    }

    public function attributeLabels()
    {
        return [
            'name' => trans('subr::content.name'),
            'price' => trans('subr::content.price'),
            'period' => trans('subr::content.period'),
            'period_unit' => trans('subr::content.period_unit'),
            'module' => trans('subr::content.module'),
            'is_free' => trans('subr::content.is_free'),
        ];
    }

    public function configs()
    {
        return $this->hasMany(PackageConfig::class, 'package_id', 'id');
    }

    public function plans()
    {
        return $this->hasMany(PackagePlan::class, 'package_id', 'id');
    }

    public function syncConfigs(array $data = [])
    {
        foreach ($data as $key => $val) {
            $this->configs()->updateOrCreate([
                'code' => $key
            ], [
                'value' => $val
            ]);
        }

        $this->configs()
            ->whereNotIn('code', array_keys($data))
            ->delete();
    }

    public function getData()
    {
        return (new Collection($this->data));
    }

    public function getConfig($key)
    {
        $config = $this->configs()
            ->where('code', '=', $key)
            ->first(['value']);

        if ($config) {
            return $config->value;
        }

        $module = HookAction::getPackageModules($this->module);

        return Arr::get($module, "config.{$key}.default");
    }

    public function getModuleConfig()
    {
        return HookAction::getPackageModules($this->module);
    }

    public function getReturnUrl()
    {
        $module = $this->getModuleConfig();
        return $module->get('return_url', route('admin.dashboard'));
    }
}
