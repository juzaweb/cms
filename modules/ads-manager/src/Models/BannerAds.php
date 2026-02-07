<?php

namespace Juzaweb\Modules\AdsManagement\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Juzaweb\Modules\AdsManagement\Database\Factories\BannerAdsFactory;
use Juzaweb\Modules\AdsManagement\Enums\BannerAdsType;
use Juzaweb\Modules\Core\Facades\Theme;
use Juzaweb\Modules\Core\Models\Model;

class BannerAds extends Model
{
    use HasUuids, HasFactory;

    protected $table = 'banner_ads';

    protected $fillable = [
        'name',
        'body',
        'active',
        'url',
        'size',
        'type',
        'views',
        'click',
    ];

    protected $casts = [
        'active' => 'boolean',
        'views' => 'integer',
        'click' => 'integer',
        'type' => BannerAdsType::class,
    ];

    public function positions(): MorphMany
    {
        return $this->morphMany(AdPosition::class, 'positionable');
    }

    public function getBody(): ?string
    {
        if ($this->type == BannerAdsType::TYPE_BANNER) {
            return '<a href="' . $this->url . '" target="_blank"><img src="' . upload_url($this->body) . '"></a>';
        }

        return $this->body;
    }

    public function scopeWhereFrontend(Builder $builder): Builder
    {
        return $builder->where('active', true);
    }

    public function scopeWherePosition(Builder $builder, string $position): Builder
    {
        return $builder->select(['banner_ads.*'])
            ->join('ad_positions', function ($join) use ($position) {
                $join->on('ad_positions.positionable_id', '=', 'banner_ads.id')
                    ->where('ad_positions.positionable_type', '=', self::class)
                    ->where('ad_positions.position', '=', $position)
                    ->where('ad_positions.theme', '=', Theme::current()->name());
            });
    }

    protected static function newFactory(): BannerAdsFactory
    {
        return BannerAdsFactory::new();
    }

    public static function getFieldName(): string
    {
        return 'name';
    }
}
